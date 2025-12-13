<?php

namespace App\Exports;

use App\Models\DaftarAkun;
use App\Models\SaldoAwal;
use App\Models\JurnalUmum;
use Maatwebsite\Excel\Concerns\FromArray;

class LaporanExport implements FromArray
{
    public function array(): array
    {
        $tahun = date('Y');
        $saldoAwal = SaldoAwal::where('tahun', $tahun)->pluck('saldo', 'kode_akun')->toArray();
        $debet = JurnalUmum::whereYear('tanggal', $tahun)->groupBy('kode_akun_debet')->pluck('jumlah', 'kode_akun_debet');
        $kredit = JurnalUmum::whereYear('tanggal', $tahun)->groupBy('kode_akun_kredit')->pluck('jumlah', 'kode_akun_kredit');
        $akuns = DaftarAkun::orderBy('kode_akun')->get();

        $data = [['LAPORAN KEUANGAN TAHUN ' . $tahun], ['']];

        foreach ($akuns as $a) {
            $awal = $saldoAwal[$a->kode_akun] ?? 0;
            $d = $debet[$a->kode_akun] ?? 0;
            $k = $kredit[$a->kode_akun] ?? 0;
            $saldo = $a->posisi_saldo == 'DEBET' ? $awal + $d - $k : $awal + $k - $d;
            if ($saldo != 0) {
                $data[] = [$a->kode_akun . ' - ' . $a->nama_akun, $saldo];
            }
        }

        return $data;
    }
}