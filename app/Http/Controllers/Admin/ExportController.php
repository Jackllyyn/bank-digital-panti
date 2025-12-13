<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JurnalUmum;
use App\Models\DaftarAkun;
use App\Models\SaldoAwal;
use App\Models\IdentitasPanti;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class ExportController extends Controller
{
    public function jurnalExcel()
    {
        return Excel::download(new \App\Exports\JurnalExport, 'Jurnal_Umum_'.date('Y-m-d').'.xlsx');
    }

    public function jurnalPdf()
    {
        $identitas = IdentitasPanti::first();
        $jurnals = JurnalUmum::with(['user', 'akunDebet', 'akunKredit'])
                     ->orderBy('tanggal', 'desc')
                     ->get();

        $pdf = Pdf::loadView('admin.exports.jurnal-pdf', compact('jurnals', 'identitas'));
        $pdf->setPaper('A4', 'landscape');
        return $pdf->download('Jurnal_Umum_'.date('Y-m-d').'.pdf');
    }

    public function laporanPdf()
    {
        $identitas = IdentitasPanti::first();
        $tahun = date('Y'); // SUDAH ADA

        $saldoAwal = SaldoAwal::where('tahun', $tahun)->pluck('saldo', 'kode_akun')->toArray();

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
        foreach ($akuns as $a) {
            $awal = $saldoAwal[$a->kode_akun] ?? 0;
            $d    = $debet[$a->kode_akun] ?? 0;
            $k    = $kredit[$a->kode_akun] ?? 0;
            $saldo = $a->posisi_saldo == 'DEBET' ? $awal + $d - $k : $awal + $k - $d;
            $saldoAkhir[$a->kode_akun] = $saldo;
        }

        $pdf = Pdf::loadView('admin.exports.laporan-pdf', compact('akuns', 'saldoAkhir', 'tahun', 'identitas'));
        $pdf->setPaper('A4', 'portrait');
        return $pdf->download('Laporan_Keuangan_'.$tahun.'.pdf');
    }

    // PERBAIKAN UTAMA: TAMBAHKAN $tahun DI SINI!
    public function laporanExcel()
    {
        $tahun = date('Y'); // INI YANG HILANG!

        return Excel::download(new class($tahun) implements \Maatwebsite\Excel\Concerns\FromArray {
            protected $tahun;

            public function __construct($tahun)
            {
                $this->tahun = $tahun;
            }

            public function array(): array
            {
                $saldoAwal = SaldoAwal::where('tahun', $this->tahun)->pluck('saldo', 'kode_akun')->toArray();

                $debet = JurnalUmum::whereYear('tanggal', $this->tahun)
                    ->groupBy('kode_akun_debet')
                    ->selectRaw('kode_akun_debet, SUM(jumlah) as total')
                    ->pluck('total', 'kode_akun_debet');

                $kredit = JurnalUmum::whereYear('tanggal', $this->tahun)
                    ->groupBy('kode_akun_kredit')
                    ->selectRaw('kode_akun_kredit, SUM(jumlah) as total')
                    ->pluck('total', 'kode_akun_kredit');

                $akuns = DaftarAkun::orderBy('kode_akun')->get();
                $data = [['LAPORAN KEUANGAN TAHUN ' . $this->tahun], [''], ['KODE', 'NAMA AKUN', 'SALDO AKHIR']];

                foreach ($akuns as $a) {
                    $awal = $saldoAwal[$a->kode_akun] ?? 0;
                    $d = $debet[$a->kode_akun] ?? 0;
                    $k = $kredit[$a->kode_akun] ?? 0;
                    $saldo = $a->posisi_saldo == 'DEBET' ? $awal + $d - $k : $awal + $k - $d;
                    if ($saldo != 0) {
                        $data[] = [$a->kode_akun, $a->nama_akun, $saldo];
                    }
                }
                return $data;
            }
        }, 'Laporan_Keuangan_'.$tahun.'.xlsx');
    }
}