<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use App\Models\IdentitasPanti;

class PengeluaranExport implements 
    FromCollection, 
    WithHeadings, 
    WithMapping, 
    ShouldAutoSize, 
    WithStyles
{
    protected $pengeluarans;
    protected $totalJumlah;

    public function __construct(Collection $pengeluarans)
    {
        $this->pengeluarans = $pengeluarans;
        $this->totalJumlah = $pengeluarans->sum('jumlah');
    }

    public function collection(): Collection
    {
        $data = $this->pengeluarans->map(function ($item) {
            return $item;
        });

        // Baris total
        $data->push((object)[
            'tanggal'          => '',
            'akunBeban'        => '',
            'sumberBayar'      => '',
            'jumlah'           => $this->totalJumlah,
            'keterangan'       => 'TOTAL PENGELUARAN OPERASIONAL',
            'no_bukti'         => '',
            'user'             => '',
        ]);

        return $data;
    }

    public function headings(): array
    {
        $identitas = IdentitasPanti::first() ?? new IdentitasPanti();

        return [
            ['LAPORAN PENGELUARAN OPERASIONAL'],
            [$identitas->nama_panti ?? 'PANTI ASUHAN'],
            [$identitas->nama_yayasan ?? ''],
            ['Periode: ' . (request('dari') ? \Carbon\Carbon::parse(request('dari'))->format('d/m/Y') : '-') 
                . ' s/d ' . (request('sampai') ? \Carbon\Carbon::parse(request('sampai'))->format('d/m/Y') : date('d/m/Y'))],
            [], // pemisah
            [
                'Tanggal',
                'Akun Beban',
                'Sumber Bayar (Kas/Bank)',
                'Jumlah (Rp)',
                'Keterangan',
                'No. Bukti',
                'User Input',
            ]
        ];
    }

    public function map($pengeluaran): array
    {
        $jumlahFormatted = number_format($pengeluaran->jumlah ?? 0, 2, ',', '.');

        // Baris total
        if (isset($pengeluaran->keterangan) && str_contains($pengeluaran->keterangan, 'TOTAL')) {
            return [
                '',
                '',
                '',
                $jumlahFormatted,
                $pengeluaran->keterangan,
                '',
                '',
            ];
        }

        return [
            $pengeluaran->tanggal?->format('d/m/Y') ?? '-',
            $pengeluaran->akun 
                ? $pengeluaran->akun->kode_akun . ' - ' . $pengeluaran->akun->nama_akun 
                : '-',
            $pengeluaran->akunKredit 
                ? $pengeluaran->akunKredit->kode_akun . ' - ' . $pengeluaran->akunKredit->nama_akun 
                : '-',
            $jumlahFormatted,
            $pengeluaran->keterangan ?? '-',
            $pengeluaran->no_bukti ?? '-',
            $pengeluaran->user?->name ?? '-',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $highestRow = $sheet->getHighestRow();

        return [
            1 => ['font' => ['bold' => true, 'size' => 16]],
            2 => ['font' => ['bold' => true, 'size' => 14]],
            3 => ['font' => ['size' => 12]],
            4 => ['font' => ['italic' => true, 'size' => 11]],
            6 => ['font' => ['bold' => true], 'fill' => ['fillType' => 'solid', 'startColor' => ['argb' => 'FFE2E8F0']]],
            $highestRow => [
                'font' => ['bold' => true, 'size' => 12],
                'fill' => ['fillType' => 'solid', 'startColor' => ['argb' => 'FFFFD1D1']], // warna merah muda soft untuk total pengeluaran
            ],
            'D' => ['alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT]],
        ];
    }
}