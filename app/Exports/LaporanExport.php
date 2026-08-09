<?php

namespace App\Exports;

use App\Models\DaftarAkun;
use App\Models\SaldoAwal;
use App\Models\JurnalUmum;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class LaporanExport implements FromArray, ShouldAutoSize, WithColumnFormatting, WithStyles
{
    protected $tahun;

    public function __construct($tahun = null)
    {
        $this->tahun = $tahun ?? date('Y');
    }

    public function array(): array
    {
        $akuns = DaftarAkun::orderBy('kode_akun')->get();

        $saldoAwal = SaldoAwal::where('tahun', $this->tahun)
            ->pluck('saldo', 'kode_akun')
            ->toArray();

        $debetMutasi = JurnalUmum::whereYear('tanggal', $this->tahun)
            ->groupBy('kode_akun_debet')
            ->select('kode_akun_debet', \DB::raw('SUM(jumlah) as total'))
            ->pluck('total', 'kode_akun_debet')
            ->toArray() + array_fill_keys($akuns->pluck('kode_akun')->toArray(), 0);

        $kreditMutasi = JurnalUmum::whereYear('tanggal', $this->tahun)
            ->groupBy('kode_akun_kredit')
            ->select('kode_akun_kredit', \DB::raw('SUM(jumlah) as total'))
            ->pluck('total', 'kode_akun_kredit')
            ->toArray() + array_fill_keys($akuns->pluck('kode_akun')->toArray(), 0);

        $exportData = [];

        $exportData[] = ["LAPORAN KEUANGAN TAHUN {$this->tahun}"];
        $exportData[] = [];
        $exportData[] = ['Kode Akun', 'Nama Akun', 'Debet', 'Kredit'];

        $totalsDebet   = ['ASET' => 0, 'LIABILITAS' => 0, 'EKUITAS' => 0, 'PENDAPATAN' => 0, 'BEBAN' => 0];
        $totalsKredit  = ['ASET' => 0, 'LIABILITAS' => 0, 'EKUITAS' => 0, 'PENDAPATAN' => 0, 'BEBAN' => 0];
        $totalsSaldo   = ['ASET' => 0, 'LIABILITAS' => 0, 'EKUITAS' => 0, 'PENDAPATAN' => 0, 'BEBAN' => 0];

        $prevKelompok = null;

        foreach ($akuns as $akun) {
            $awal   = $saldoAwal[$akun->kode_akun] ?? 0;
            $debet  = $debetMutasi[$akun->kode_akun] ?? 0;
            $kredit = $kreditMutasi[$akun->kode_akun] ?? 0;

            if ($prevKelompok !== null && $prevKelompok !== $akun->kelompok) {
                $exportData[] = [
                    "Subtotal {$prevKelompok}",
                    '',
                    $totalsDebet[$prevKelompok],
                    $totalsKredit[$prevKelompok]
                ];
                $exportData[] = [];
            }

            if ($prevKelompok !== $akun->kelompok) {
                $exportData[] = [$akun->kelompok];
                $exportData[] = ['Kode Akun', 'Nama Akun', 'Debet', 'Kredit'];
                $prevKelompok = $akun->kelompok;
            }

            $exportData[] = [
                $akun->kode_akun,
                $akun->nama_akun,
                $debet,
                $kredit
            ];

            $totalsDebet[$akun->kelompok]  += $debet;
            $totalsKredit[$akun->kelompok] += $kredit;

            $saldoAkhir = $akun->posisi_saldo === 'DEBET'
                ? $awal + $debet - $kredit
                : $awal + $kredit - $debet;

            $totalsSaldo[$akun->kelompok] += $saldoAkhir;
        }

       
        if ($prevKelompok !== null) {
            $exportData[] = [
                "Subtotal {$prevKelompok}",
                '',
                $totalsDebet[$prevKelompok],
                $totalsKredit[$prevKelompok]
            ];
            $exportData[] = [];
        }

      
        $pendapatan = $totalsKredit['PENDAPATAN'] ?? 0;  
        $beban      = $totalsDebet['BEBAN'] ?? 0;        

        $labaRugi = $pendapatan - $beban;

        $exportData[] = ['RINGKASAN LABA / RUGI TAHUN BERJALAN'];
        $exportData[] = ['Deskripsi', 'Jumlah'];
        $exportData[] = ['Pendapatan Keseluruhan', $pendapatan];
        $exportData[] = ['Beban / Pengeluaran Keseluruhan', $beban];
        $exportData[] = ['Laba / (Rugi) Bersih', $labaRugi];

       
        $exportData[] = [];
        $exportData[] = ['Ringkasan Neraca (Saldo Akhir)'];
        $exportData[] = ['Total Aset', $totalsSaldo['ASET']];
        $exportData[] = ['Total Liabilitas + Ekuitas', $totalsSaldo['LIABILITAS'] + $totalsSaldo['EKUITAS']];

        return $exportData;
    }

    public function columnFormats(): array
    {
        return [
            'C' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'D' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'B10:B20' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();

        $sheet->getStyle("A3:{$highestColumn}{$highestRow}")->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF999999'],
                ],
            ],
        ]);

        $sheet->getStyle('A1')->applyFromArray([
            'font' => ['bold' => true, 'size' => 16],
            'alignment' => ['horizontal' => 'center'],
        ]);
        $sheet->mergeCells('A1:D1');

        $sheet->getStyle('A3:D3')->applyFromArray([
            'font' => ['bold' => true],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFE6F3E6']],
        ]);

       
        $sheet->getStyle('A' . ($highestRow - 5) . ':B' . $highestRow)->applyFromArray([
            'font' => ['bold' => true],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFFFF0E6']],
        ]);

        foreach (range(1, $highestRow) as $row) {
            $value = $sheet->getCell("A{$row}")->getValue();
            if (in_array($value, ['ASET', 'LIABILITAS', 'EKUITAS', 'PENDAPATAN', 'BEBAN'])) {
                $sheet->getStyle("A{$row}:D{$row}")->applyFromArray([
                    'font' => ['bold' => true],
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFDDEEDD']],
                ]);
                $sheet->mergeCells("A{$row}:D{$row}");
            }

            if (str_starts_with($value ?? '', 'Subtotal')) {
                $sheet->getStyle("A{$row}:D{$row}")->applyFromArray([
                    'font' => ['bold' => true],
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFF0FFF0']],
                ]);
            }
        }

        return [];
    }
}