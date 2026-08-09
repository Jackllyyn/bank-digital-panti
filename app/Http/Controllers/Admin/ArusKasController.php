<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JurnalUmum;
use App\Models\SaldoAwal;
use App\Models\DaftarAkun;
use App\Models\IdentitasPanti;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class ArusKasController extends Controller
{
    /**
     * Mendapatkan daftar kode akun yang dianggap sebagai Kas atau Bank.
     * Mengambil dari database berdasarkan nama akun yang mengandung kata "Kas" atau "Bank".
     */
    private function getCashAccounts()
    {
        $accounts = DaftarAkun::where('nama_akun', 'like', '%Kas%')
            ->orWhere('nama_akun', 'like', '%Bank%')
            ->pluck('kode_akun')
            ->toArray();

        // Fallback jika tidak ditemukan, agar query whereIn tidak error
        return empty($accounts) ? ['0000'] : $accounts;
    }

    public function index(Request $request)
    {
        $tglAwal = $request->input('tgl_awal', date('Y-m-01'));
        $tglAkhir = $request->input('tgl_akhir', date('Y-m-d'));
        $kategori = $request->input('kategori');

        $data = $this->getData($tglAwal, $tglAkhir, $kategori);
        $kategoriList = ['ASET', 'LIABILITAS', 'EKUITAS', 'PENDAPATAN', 'BEBAN'];

        return view('admin.arus-kas.arus-kas', array_merge($data, compact('tglAwal', 'tglAkhir', 'kategori', 'kategoriList')));
    }

    public function exportPdf(Request $request)
    {
        $tglAwal = $request->input('tgl_awal', date('Y-m-01'));
        $tglAkhir = $request->input('tgl_akhir', date('Y-m-d'));
        $kategori = $request->input('kategori');

        $data = $this->getData($tglAwal, $tglAkhir, $kategori);
        $identitas = IdentitasPanti::first();

        $pdf = Pdf::loadView('admin.exports.arus-kas-pdf', array_merge($data, compact('tglAwal', 'tglAkhir', 'identitas')));
        $pdf->setPaper('A4', 'portrait');

        return $pdf->stream('Laporan_Arus_Kas_'.$tglAwal.'_sd_'.$tglAkhir.'.pdf');
    }

    private function getData($tglAwal, $tglAkhir, $kategori = null)
    {
        $tahun = date('Y', strtotime($tglAwal));
        $cashAccounts = $this->getCashAccounts();

        // 1. Hitung Saldo Awal Kas & Bank (Per Tanggal Awal)
        // Saldo Awal Tahun
        $saldoAwalTahun = SaldoAwal::where('tahun', $tahun)
            ->whereIn('kode_akun', $cashAccounts)
            ->sum('saldo');

        // Mutasi dari 1 Jan s/d Sebelum Tanggal Awal
        $debetSebelumnya = JurnalUmum::where('tanggal', '>=', $tahun . '-01-01')
            ->where('tanggal', '<', $tglAwal)
            ->whereIn('kode_akun_debet', $cashAccounts)
            ->where('no_transaksi', 'not like', 'CL-%')
            ->sum('jumlah');

        $kreditSebelumnya = JurnalUmum::where('tanggal', '>=', $tahun . '-01-01')
            ->where('tanggal', '<', $tglAwal)
            ->whereIn('kode_akun_kredit', $cashAccounts)
            ->where('no_transaksi', 'not like', 'CL-%')
            ->sum('jumlah');

        $saldoAwal = $saldoAwalTahun + $debetSebelumnya - $kreditSebelumnya;

        // 2. Arus Kas Masuk (Inflow)
        // Debet = Kas/Bank, Kredit = BUKAN Kas/Bank (agar transfer internal tidak double count)
        $arusMasukQuery = JurnalUmum::with('akunKredit')
            ->whereIn('kode_akun_debet', $cashAccounts)
            ->whereNotIn('kode_akun_kredit', $cashAccounts) // Exclude internal transfer
            ->whereBetween('tanggal', [$tglAwal, $tglAkhir])
            ->where('no_transaksi', 'not like', 'CL-%');

        if ($kategori) {
            $arusMasukQuery->whereHas('akunKredit', function ($q) use ($kategori) {
                $q->where('kelompok', $kategori);
            });
        }

        $arusMasuk = $arusMasukQuery
            ->select('kode_akun_kredit', DB::raw('SUM(jumlah) as total'))
            ->groupBy('kode_akun_kredit')
            ->get();

        // 3. Arus Kas Keluar (Outflow)
        // Kredit = Kas/Bank, Debet = BUKAN Kas/Bank
        $arusKeluarQuery = JurnalUmum::with('akunDebet')
            ->whereIn('kode_akun_kredit', $cashAccounts)
            ->whereNotIn('kode_akun_debet', $cashAccounts) // Exclude internal transfer
            ->whereBetween('tanggal', [$tglAwal, $tglAkhir])
            ->where('no_transaksi', 'not like', 'CL-%');

        if ($kategori) {
            $arusKeluarQuery->whereHas('akunDebet', function ($q) use ($kategori) {
                $q->where('kelompok', $kategori);
            });
        }

        $arusKeluar = $arusKeluarQuery
            ->select('kode_akun_debet', DB::raw('SUM(jumlah) as total'))
            ->groupBy('kode_akun_debet')
            ->get();

        $totalMasuk = $arusMasuk->sum('total');
        $totalKeluar = $arusKeluar->sum('total');
        $saldoAkhir = $saldoAwal + $totalMasuk - $totalKeluar;

        return compact('saldoAwal', 'arusMasuk', 'arusKeluar', 'totalMasuk', 'totalKeluar', 'saldoAkhir');
    }
}
