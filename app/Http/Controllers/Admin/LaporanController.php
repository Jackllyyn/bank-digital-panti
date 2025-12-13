<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DaftarAkun;
use App\Models\SaldoAwal;
use App\Models\JurnalUmum;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function index()
    {
        $tahun = date('Y');

        // Saldo Awal
        $saldoAwal = SaldoAwal::where('tahun', $tahun)
            ->pluck('saldo', 'kode_akun')
            ->toArray();

        // Mutasi Debet & Kredit
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
        $aset = 0; $liabilitas = 0; $ekuitas = 0; $pendapatan = 0; $beban = 0;

        foreach ($akuns as $akun) {
            $awal = $saldoAwal[$akun->kode_akun] ?? 0;
            $d    = $debet[$akun->kode_akun] ?? 0;
            $k    = $kredit[$akun->kode_akun] ?? 0;

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

        return view('admin.laporan.index', compact(
            'akuns',
            'saldoAkhir',
            'tahun',
            'aset',
            'liabilitas',
            'ekuitas',
            'pendapatan',
            'beban'
        ));
    }
}