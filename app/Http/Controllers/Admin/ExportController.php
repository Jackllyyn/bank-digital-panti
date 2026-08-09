<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JurnalUmum;
use App\Models\DaftarAkun;
use App\Models\Karyawan;
use App\Models\Donatur;
use App\Models\SaldoAwal;
use App\Models\IdentitasPanti;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

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

    public function donaturExcel(Request $request)
    {
        // 1. Buat query yang sama dengan di DonaturController@index
        $query = Donatur::query();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->search . '%')
                    ->orWhere('kode_donatur', 'like', '%' . $request->search . '%')
                    ->orWhere('kota', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('jenis_donatur')) {
            $query->where('jenis_donatur', $request->jenis_donatur);
        }

        if ($request->filled('klasifikasi')) {
            $query->where('klasifikasi', $request->klasifikasi);
        }

        // 2. Ambil data dengan withMax untuk efisiensi kolom "Terakhir Donasi"
        $donaturs = $query->withMax('penerimaanDonasi', 'tanggal')
            ->orderBy('kode_donatur')
            ->get();

        // 3. Buat objek export menggunakan anonymous class
        $export = new class($donaturs) implements \Maatwebsite\Excel\Concerns\FromCollection, \Maatwebsite\Excel\Concerns\WithHeadings, \Maatwebsite\Excel\Concerns\ShouldAutoSize, \Maatwebsite\Excel\Concerns\WithMapping {
            protected $donaturs;

            public function __construct($donaturs)
            {
                $this->donaturs = $donaturs;
            }

            public function collection()
            {
                return $this->donaturs;
            }

            public function headings(): array
            {
                return [
                    'Kode Donatur',
                    'Nama',
                    'Jenis Donatur',
                    'Kota',
                    'Pekerjaan',
                    'Klasifikasi',
                    'Tanggal Daftar',
                    'Terakhir Donasi',
                    'Total Donasi Uang',
                    'Total Nilai Barang',
                    'Total Keseluruhan',
                ];
            }

            public function map($donatur): array
            {
                return [
                    $donatur->kode_donatur,
                    $donatur->nama,
                    $donatur->jenis_donatur_display,
                    $donatur->kota,
                    $donatur->pekerjaan,
                    ucwords($donatur->klasifikasi),
                    $donatur->tanggal_daftar_formatted,
                    $donatur->terakhir_donasi_formatted,
                    $donatur->total_donasi, // Angka mentah untuk Excel
                    $donatur->total_nilai_donasi_barang, // Angka mentah
                    $donatur->total_keseluruhan, // Angka mentah
                ];
            }
        };

        // 4. Download file Excel
        return Excel::download($export, 'Laporan_Donatur_' . date('Y-m-d_His') . '.xlsx');
    }

    public function karyawanExcel(Request $request)
    {
        // 1. Buat query yang sama dengan di KaryawanController@index
        $query = Karyawan::query();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->search . '%')
                    ->orWhere('nip', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('jenis_karyawan')) {
            $query->where('jenis_karyawan', 'like', '%' . $request->jenis_karyawan . '%');
        }

        // 2. Ambil semua data yang cocok
        $karyawans = $query->orderBy('nama')->get();

        // 3. Buat objek export
        $export = new class($karyawans) implements \Maatwebsite\Excel\Concerns\FromCollection, \Maatwebsite\Excel\Concerns\WithHeadings, \Maatwebsite\Excel\Concerns\ShouldAutoSize, \Maatwebsite\Excel\Concerns\WithMapping {
            protected $karyawans;

            public function __construct($karyawans)
            {
                $this->karyawans = $karyawans;
            }

            public function collection()
            {
                return $this->karyawans;
            }

            public function headings(): array
            {
                return [
                    'NIP',
                    'Nama',
                    'Jenis Karyawan',
                    'Jenis Kelamin',
                    'Jabatan',
                    'Tanggal Daftar',
                    'Telepon',
                    'Alamat',
                    'Kota',
                    'Gaji Pokok',
                    'Tunjangan',
                    'Potongan',
                    'Gaji Bersih',
                ];
            }

            public function map($karyawan): array
            {
                return [
                    $karyawan->nip,
                    $karyawan->nama,
                    $karyawan->jenis_karyawan,
                    $karyawan->jenis_kelamin,
                    $karyawan->jabatan,
                    $karyawan->tanggal_daftar_formatted,
                    $karyawan->telepon,
                    $karyawan->alamat_lengkap,
                    $karyawan->kota,
                    $karyawan->gaji_pokok,
                    $karyawan->tunjangan,
                    $karyawan->potongan_gaji,
                    $karyawan->gaji_bersih,
                ];
            }
        };

        // 4. Download file Excel
        return Excel::download($export, 'Laporan_Karyawan_' . date('Y-m-d_His') . '.xlsx');
    }

    public function laporanPdf(Request $request)
    {
        $identitas = IdentitasPanti::first();
        $tglAwal = $request->input('tgl_awal', date('Y-01-01'));
        $tglAkhir = $request->input('tgl_akhir', date('Y-m-d'));
        $tahun = date('Y', strtotime($tglAwal));

        $saldoAwal = SaldoAwal::where('tahun', $tahun)->pluck('saldo', 'kode_akun')->toArray();

        // Mutasi Neraca (Jan 1 - Tgl Akhir)
        $neracaDebet = JurnalUmum::where('tanggal', '>=', $tahun . '-01-01')->where('tanggal', '<=', $tglAkhir)
            ->where('no_transaksi', 'not like', 'CL-%')
            ->groupBy('kode_akun_debet')
            ->pluck(DB::raw('SUM(jumlah)'), 'kode_akun_debet');
        $neracaKredit = JurnalUmum::where('tanggal', '>=', $tahun . '-01-01')->where('tanggal', '<=', $tglAkhir)
            ->where('no_transaksi', 'not like', 'CL-%')
            ->groupBy('kode_akun_kredit')
            ->pluck(DB::raw('SUM(jumlah)'), 'kode_akun_kredit');

        // Mutasi Laba Rugi (Tgl Awal - Tgl Akhir)
        $lrDebet = JurnalUmum::where('tanggal', '>=', $tglAwal)->where('tanggal', '<=', $tglAkhir)
            ->where('no_transaksi', 'not like', 'CL-%')
            ->groupBy('kode_akun_debet')
            ->pluck(DB::raw('SUM(jumlah)'), 'kode_akun_debet');
        $lrKredit = JurnalUmum::where('tanggal', '>=', $tglAwal)->where('tanggal', '<=', $tglAkhir)
            ->where('no_transaksi', 'not like', 'CL-%')
            ->groupBy('kode_akun_kredit')
            ->pluck(DB::raw('SUM(jumlah)'), 'kode_akun_kredit');

        $akuns = DaftarAkun::orderBy('kode_akun')->get();

        $saldoAkhir = [];
        $aset = 0; $liabilitas = 0; $ekuitas = 0; $pendapatan = 0; $beban = 0;

        foreach ($akuns as $a) {
            $isNeraca = in_array($a->kelompok, ['ASET', 'LIABILITAS', 'EKUITAS']);
            if ($isNeraca) {
                $awal = $saldoAwal[$a->kode_akun] ?? 0;
                $d = $neracaDebet[$a->kode_akun] ?? 0;
                $k = $neracaKredit[$a->kode_akun] ?? 0;
            } else {
                $awal = 0;
                $d = $lrDebet[$a->kode_akun] ?? 0;
                $k = $lrKredit[$a->kode_akun] ?? 0;
            }

            $saldo = $a->posisi_saldo == 'DEBET' ? $awal + $d - $k : $awal + $k - $d;
            $saldoAkhir[$a->kode_akun] = $saldo;

            // Hitung total per kelompok
            if ($a->kelompok == 'ASET') $aset += $saldo;
            elseif ($a->kelompok == 'LIABILITAS') $liabilitas += $saldo;
            elseif ($a->kelompok == 'EKUITAS') $ekuitas += $saldo;
            elseif ($a->kelompok == 'PENDAPATAN') $pendapatan += $saldo;
            elseif ($a->kelompok == 'BEBAN') $beban += $saldo;
        }

        $surplusDefisit = $pendapatan - $beban;

        $pdf = Pdf::loadView('admin.exports.laporan-pdf', compact(
            'akuns', 'saldoAkhir', 'tahun', 'identitas', 'tglAwal', 'tglAkhir',
            'aset', 'liabilitas', 'ekuitas', 'pendapatan', 'beban', 'surplusDefisit'
        ));
        $pdf->setPaper('A4', 'portrait');
        return $pdf->stream('Laporan_Keuangan_'.$tglAwal.'_sd_'.$tglAkhir.'.pdf');
    }

    public function laporanExcel(Request $request)
    {
        $tglAwal = $request->input('tgl_awal', date('Y-01-01'));
        $tglAkhir = $request->input('tgl_akhir', date('Y-m-d'));
        $tahun = date('Y', strtotime($tglAwal));

        return Excel::download(new class($tglAwal, $tglAkhir, $tahun) implements \Maatwebsite\Excel\Concerns\FromArray {
            protected $tglAwal, $tglAkhir, $tahun;

            public function __construct($tglAwal, $tglAkhir, $tahun)
            {
                $this->tglAwal = $tglAwal;
                $this->tglAkhir = $tglAkhir;
                $this->tahun = $tahun;
            }

            public function array(): array
            {
                $saldoAwal = SaldoAwal::where('tahun', $this->tahun)->pluck('saldo', 'kode_akun')->toArray();

                // Mutasi Neraca
                $neracaDebet = JurnalUmum::where('tanggal', '>=', $this->tahun . '-01-01')->where('tanggal', '<=', $this->tglAkhir)
                    ->groupBy('kode_akun_debet')
                    ->pluck(DB::raw('SUM(jumlah)'), 'kode_akun_debet');
                $neracaKredit = JurnalUmum::where('tanggal', '>=', $this->tahun . '-01-01')->where('tanggal', '<=', $this->tglAkhir)
                    ->groupBy('kode_akun_kredit')
                    ->pluck(DB::raw('SUM(jumlah)'), 'kode_akun_kredit');

                // Mutasi Laba Rugi
                $lrDebet = JurnalUmum::where('tanggal', '>=', $this->tglAwal)->where('tanggal', '<=', $this->tglAkhir)
                    ->groupBy('kode_akun_debet')
                    ->pluck(DB::raw('SUM(jumlah)'), 'kode_akun_debet');
                $lrKredit = JurnalUmum::where('tanggal', '>=', $this->tglAwal)->where('tanggal', '<=', $this->tglAkhir)
                    ->groupBy('kode_akun_kredit')
                    ->pluck(DB::raw('SUM(jumlah)'), 'kode_akun_kredit');

                $akuns = DaftarAkun::orderBy('kode_akun')->get();
                $data = [['LAPORAN KEUANGAN PERIODE ' . $this->tglAwal . ' s/d ' . $this->tglAkhir], [''], ['KODE', 'NAMA AKUN', 'SALDO AKHIR']];

                foreach ($akuns as $a) {
                    $isNeraca = in_array($a->kelompok, ['ASET', 'LIABILITAS', 'EKUITAS']);
                    if ($isNeraca) {
                        $awal = $saldoAwal[$a->kode_akun] ?? 0;
                        $d = $neracaDebet[$a->kode_akun] ?? 0;
                        $k = $neracaKredit[$a->kode_akun] ?? 0;
                    } else {
                        $awal = 0;
                        $d = $lrDebet[$a->kode_akun] ?? 0;
                        $k = $lrKredit[$a->kode_akun] ?? 0;
                    }

                    $saldo = $a->posisi_saldo == 'DEBET' ? $awal + $d - $k : $awal + $k - $d;
                    if ($saldo != 0) {
                        $data[] = [$a->kode_akun, $a->nama_akun, $saldo];
                    }
                }
                return $data;
            }
        }, 'Laporan_Keuangan_'.$tglAwal.'_sd_'.$tglAkhir.'.xlsx');
    }
}