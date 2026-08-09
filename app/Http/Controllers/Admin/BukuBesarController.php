<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DaftarAkun;
use App\Models\JurnalUmum;
use App\Models\SaldoAwal;
use App\Models\IdentitasPanti;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class BukuBesarController extends Controller
{
    public function index(Request $request)
    {
        $akuns = DaftarAkun::orderBy('kode_akun')->get();

        $tglAwal = $request->input('tgl_awal', date('Y-m-01'));
        $tglAkhir = $request->input('tgl_akhir', date('Y-m-d'));
        $kodeAkun = $request->input('kode_akun');

        $data = $this->getData($tglAwal, $tglAkhir, $kodeAkun);

        return view('admin.buku-besar.buku-besar', array_merge($data, compact('akuns')));
    }

    public function exportPdf(Request $request)
    {
        $tglAwal = $request->input('tgl_awal', date('Y-m-01'));
        $tglAkhir = $request->input('tgl_akhir', date('Y-m-d'));
        $kodeAkun = $request->input('kode_akun');

        if (!$kodeAkun) {
            return redirect()->back()->with('error', 'Silakan pilih akun terlebih dahulu untuk mencetak PDF.');
        }

        $data = $this->getData($tglAwal, $tglAkhir, $kodeAkun);
        $identitas = IdentitasPanti::first();

        $pdf = Pdf::loadView('admin.exports.buku-besar-pdf', array_merge($data, compact('identitas')));
        $pdf->setPaper('A4', 'portrait');
        
        return $pdf->stream('Buku_Besar_'.$kodeAkun.'_'.$tglAwal.'_sd_'.$tglAkhir.'.pdf');
    }

    public function exportExcel(Request $request)
    {
        $tglAwal = $request->input('tgl_awal', date('Y-m-01'));
        $tglAkhir = $request->input('tgl_akhir', date('Y-m-d'));
        $kodeAkun = $request->input('kode_akun');

        if (!$kodeAkun) {
            return redirect()->back()->with('error', 'Silakan pilih akun terlebih dahulu untuk mencetak Excel.');
        }

        $data = $this->getData($tglAwal, $tglAkhir, $kodeAkun);
        
        if (!$data['akunTerpilih']) {
            return redirect()->back()->with('error', 'Akun tidak ditemukan.');
        }

        $identitas = IdentitasPanti::first();
        $filename = 'Buku_Besar_' . $kodeAkun . '_' . $tglAwal . '_sd_' . $tglAkhir . '.xlsx';

        return Excel::download(new class($data, $identitas) implements \Maatwebsite\Excel\Concerns\FromArray, \Maatwebsite\Excel\Concerns\WithHeadings, \Maatwebsite\Excel\Concerns\ShouldAutoSize, \Maatwebsite\Excel\Concerns\WithStyles, \Maatwebsite\Excel\Concerns\WithColumnFormatting {
            protected $data;
            protected $identitas;

            public function __construct($data, $identitas)
            {
                $this->data = $data;
                $this->identitas = $identitas;
            }

            public function headings(): array
            {
                return [
                    [strtoupper($this->identitas->nama_yayasan ?? 'YAYASAN')],
                    ['LAPORAN BUKU BESAR'],
                    ['Periode: ' . $this->data['tglAwal'] . ' s/d ' . $this->data['tglAkhir']],
                    ['Akun: ' . $this->data['akunTerpilih']->kode_akun . ' - ' . $this->data['akunTerpilih']->nama_akun],
                    [''], // Baris kosong
                    ['TANGGAL', 'NO TRANSAKSI', 'URAIAN', 'DEBET', 'KREDIT', 'SALDO']
                ];
            }

            public function array(): array
            {
                $rows = [];
                $saldo = $this->data['saldoAwalPeriode'];

                // Baris Saldo Awal
                $rows[] = [
                    $this->data['tglAwal'],
                    '',
                    'Saldo Awal',
                    0,
                    0,
                    $saldo
                ];

                // Baris Transaksi
                foreach ($this->data['transaksi'] as $trx) {
                    $debet = ($trx->kode_akun_debet == $this->data['kodeAkun']) ? $trx->jumlah : 0;
                    $kredit = ($trx->kode_akun_kredit == $this->data['kodeAkun']) ? $trx->jumlah : 0;

                    // Hitung saldo berjalan
                    if ($this->data['akunTerpilih']->posisi_saldo == 'DEBET') {
                        $saldo += $debet - $kredit;
                    } else {
                        $saldo += $kredit - $debet;
                    }

                    $rows[] = [
                        $trx->tanggal->format('Y-m-d'),
                        $trx->no_transaksi,
                        $trx->uraian,
                        $debet,
                        $kredit,
                        $saldo
                    ];
                }
                return $rows;
            }

            public function styles(\PhpOffice\PhpSpreadsheet\Worksheet\Worksheet $sheet)
            {
                return [
                    1 => ['font' => ['bold' => true, 'size' => 14]],
                    2 => ['font' => ['bold' => true, 'size' => 12]],
                    6 => ['font' => ['bold' => true]], // Header Tabel
                ];
            }

            public function columnFormats(): array
            {
                return [
                    'D' => '#,##0', // Format Angka Debet
                    'E' => '#,##0', // Format Angka Kredit
                    'F' => '#,##0', // Format Angka Saldo
                ];
            }
        }, $filename);
    }

    private function getData($tglAwal, $tglAkhir, $kodeAkun)
    {
        $transaksi = [];
        $saldoAwalPeriode = 0;
        $akunTerpilih = null;

        if ($kodeAkun) {
            $akunTerpilih = DaftarAkun::where('kode_akun', $kodeAkun)->first();
            $tahun = date('Y', strtotime($tglAwal));

            // 1. Ambil Saldo Awal Tahun dari tabel saldo_awal
            $saldoAwalTahun = SaldoAwal::where('tahun', $tahun)
                ->where('kode_akun', $kodeAkun)
                ->value('saldo') ?? 0;

            // 2. Hitung Mutasi dari 1 Jan s/d Sehari Sebelum Tgl Awal
            // Agar kita mendapatkan "Saldo Awal per Tanggal Awal" yang diminta
            $mutasiDebet = JurnalUmum::where('kode_akun_debet', $kodeAkun)
                ->where('tanggal', '>=', $tahun . '-01-01')
                ->where('tanggal', '<', $tglAwal)
                ->where('no_transaksi', 'not like', 'CL-%') // Exclude Jurnal Penutup
                ->sum('jumlah');

            $mutasiKredit = JurnalUmum::where('kode_akun_kredit', $kodeAkun)
                ->where('tanggal', '>=', $tahun . '-01-01')
                ->where('tanggal', '<', $tglAwal)
                ->where('no_transaksi', 'not like', 'CL-%')
                ->sum('jumlah');

            // Hitung Saldo Awal Periode berdasarkan posisi normal akun
            if ($akunTerpilih->posisi_saldo == 'DEBET') {
                $saldoAwalPeriode = $saldoAwalTahun + $mutasiDebet - $mutasiKredit;
            } else {
                $saldoAwalPeriode = $saldoAwalTahun + $mutasiKredit - $mutasiDebet;
            }

            // 3. Ambil Transaksi dalam Rentang Tanggal (Buku Besar)
            $transaksi = JurnalUmum::with(['akunDebet', 'akunKredit'])
                ->where(function($q) use ($kodeAkun) {
                    $q->where('kode_akun_debet', $kodeAkun)
                      ->orWhere('kode_akun_kredit', $kodeAkun);
                })
                ->whereBetween('tanggal', [$tglAwal, $tglAkhir])
                ->where('no_transaksi', 'not like', 'CL-%')
                ->orderBy('tanggal')
                ->orderBy('id') // Urutan input jika tanggal sama
                ->get();
        }

        return compact(
            'transaksi', 
            'saldoAwalPeriode', 
            'tglAwal', 
            'tglAkhir', 
            'kodeAkun', 
            'akunTerpilih'
        );
    }
}