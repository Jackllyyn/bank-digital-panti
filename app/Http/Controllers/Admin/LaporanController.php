<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DaftarAkun;
use App\Models\SaldoAwal;
use App\Models\JurnalUmum;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $tglAwal = $request->input('tgl_awal', date('Y-01-01'));
        $tglAkhir = $request->input('tgl_akhir', date('Y-m-d'));
        $tahun = date('Y', strtotime($tglAwal));

        // 1. Saldo Awal Tahun (Tetap diambil dari tahun tgl_awal)
        $saldoAwal = SaldoAwal::where('tahun', $tahun)
            ->pluck('saldo', 'kode_akun')
            ->toArray();

        // 2. Mutasi untuk NERACA (Akumulasi dari 1 Jan s/d Tgl Akhir)
        // Neraca menunjukkan posisi keuangan PER TANGGAL TERTENTU
        $neracaDebet = JurnalUmum::where('tanggal', '>=', $tahun . '-01-01')
            ->where('tanggal', '<=', $tglAkhir)
            ->where('no_transaksi', 'not like', 'CL-%')
            ->groupBy('kode_akun_debet')
            ->pluck(DB::raw('SUM(jumlah)'), 'kode_akun_debet');

        $neracaKredit = JurnalUmum::where('tanggal', '>=', $tahun . '-01-01')
            ->where('tanggal', '<=', $tglAkhir)
            ->where('no_transaksi', 'not like', 'CL-%')
            ->groupBy('kode_akun_kredit')
            ->pluck(DB::raw('SUM(jumlah)'), 'kode_akun_kredit');

        // 3. Mutasi untuk LABA RUGI (Hanya transaksi DALAM PERIODE Tgl Awal s/d Tgl Akhir)
        // Laba Rugi menunjukkan kinerja SELAMA PERIODE
        $lrDebet = JurnalUmum::where('tanggal', '>=', $tglAwal)
            ->where('tanggal', '<=', $tglAkhir)
            ->where('no_transaksi', 'not like', 'CL-%')
            ->groupBy('kode_akun_debet')
            ->pluck(DB::raw('SUM(jumlah)'), 'kode_akun_debet');

        $lrKredit = JurnalUmum::where('tanggal', '>=', $tglAwal)
            ->where('tanggal', '<=', $tglAkhir)
            ->where('no_transaksi', 'not like', 'CL-%')
            ->groupBy('kode_akun_kredit')
            ->pluck(DB::raw('SUM(jumlah)'), 'kode_akun_kredit');

        $akuns = DaftarAkun::orderBy('kode_akun')->get();

        $saldoAkhir = [];
        $aset = 0; $liabilitas = 0; $ekuitas = 0; $pendapatan = 0; $beban = 0;

        foreach ($akuns as $akun) {
            $isNeraca = in_array($akun->kelompok, ['ASET', 'LIABILITAS', 'EKUITAS']);

            if ($isNeraca) {
                // Neraca: Saldo Awal Tahun + Mutasi (Jan 1 s/d Tgl Akhir)
                $awal = $saldoAwal[$akun->kode_akun] ?? 0;
                $d    = $neracaDebet[$akun->kode_akun] ?? 0;
                $k    = $neracaKredit[$akun->kode_akun] ?? 0;
            } else {
                // Laba Rugi: Hanya Mutasi (Tgl Awal s/d Tgl Akhir)
                // Saldo awal periode dianggap 0 untuk akun nominal dalam konteks laporan periode
                $awal = 0;
                $d    = $lrDebet[$akun->kode_akun] ?? 0;
                $k    = $lrKredit[$akun->kode_akun] ?? 0;
            }

            $saldo = $akun->posisi_saldo == 'DEBET'
                ? $awal + $d - $k
                : $awal + $k - $d;

            $saldoAkhir[$akun->kode_akun] = $saldo;

            // Hitung total per kelompok
            if ($akun->kelompok == 'ASET') {
                $aset += $saldo;
            } elseif ($akun->kelompok == 'LIABILITAS') {
                $liabilitas += $saldo;
            } elseif ($akun->kelompok == 'EKUITAS') {
                $ekuitas += $saldo;
            } elseif ($akun->kelompok == 'PENDAPATAN') {
                $pendapatan += $saldo;
            } elseif ($akun->kelompok == 'BEBAN') {
                $beban += $saldo;
            }
        }

        // Hitung Surplus/Defisit (Laba/Rugi Berjalan)
        $surplusDefisit = $pendapatan - $beban;

        return view('admin.laporan.index', compact(
            'akuns',
            'saldoAkhir',
            'tahun',
            'aset',
            'liabilitas',
            'ekuitas',
            'pendapatan',
            'beban',
            'surplusDefisit',
            'tglAwal',
            'tglAkhir'
        ));
    }

    public function neracaSaldoSetelahPenutupan()
    {
        $tahun = date('Y');

        // Saldo Awal
        $saldoAwal = SaldoAwal::where('tahun', $tahun)
            ->pluck('saldo', 'kode_akun')
            ->toArray();

        // Mutasi Debet & Kredit (INCLUDE Jurnal Penutup 'CL-%')
        // Kita ambil SEMUA jurnal tahun ini, sehingga Pendapatan & Beban akan saling hapus (jadi 0)
        $debet = JurnalUmum::whereYear('tanggal', $tahun)
            ->groupBy('kode_akun_debet')
            ->select('kode_akun_debet', DB::raw('SUM(jumlah) as total_debet'))
            ->pluck('total_debet', 'kode_akun_debet');

        $kredit = JurnalUmum::whereYear('tanggal', $tahun)
            ->groupBy('kode_akun_kredit')
            ->select('kode_akun_kredit', DB::raw('SUM(jumlah) as total_kredit'))
            ->pluck('total_kredit', 'kode_akun_kredit');

        $akuns = DaftarAkun::orderBy('kode_akun')->get();
        $saldoAkhir = [];

        foreach ($akuns as $akun) {
            $awal = $saldoAwal[$akun->kode_akun] ?? 0;
            $d    = $debet[$akun->kode_akun] ?? 0;
            $k    = $kredit[$akun->kode_akun] ?? 0;

            $saldo = $akun->posisi_saldo == 'DEBET'
                ? $awal + $d - $k
                : $awal + $k - $d;

            $saldoAkhir[$akun->kode_akun] = $saldo;
        }

        return view('admin.laporan.neraca-saldo-penutupan', compact('akuns', 'saldoAkhir', 'tahun'));
    }
}