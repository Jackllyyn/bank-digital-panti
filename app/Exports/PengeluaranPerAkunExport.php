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

class PengeluaranPerAkunExport implements 
    FromCollection, 
    WithHeadings, 
    WithMapping, 
    ShouldAutoSize, 
    WithStyles
{
    protected $pengeluarans;
    protected $namaAkun;
    protected $totalJumlah;

    public function __construct(Collection $pengeluarans, string $namaAkun)
    {
        $this->pengeluarans = $pengeluarans;
        $this->namaAkun = $namaAkun;
        $this->totalJumlah = $pengeluarans->sum('jumlah');
    }

    public function collection(): Collection
    {
        $data = $this->pengeluarans->map(fn($item) => $item);

        $data->push((object)[
            'tanggal'     => '',
            'sumberBayar' => '',
            'jumlah'      => $this->totalJumlah,
            'keterangan'  => 'TOTAL PENGELUARAN - ' . strtoupper($this->namaAkun),
            'no_bukti'    => '',
            'user'        => '',
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
            ['Akun Beban: ' . $this->namaAkun],
            ['Periode: ' . (request('dari') ? \Carbon\Carbon::parse(request('dari'))->format('d/m/Y') : '-') 
                . ' s/d ' . (request('sampai') ? \Carbon\Carbon::parse(request('sampai'))->format('d/m/Y') : date('d/m/Y'))],
            [], 
            [
                'Tanggal',
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

        if (isset($pengeluaran->keterangan) && str_contains($pengeluaran->keterangan, 'TOTAL')) {
            return [
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
            4 => ['font' => ['italic' => true, 'size' => 12]],
            5 => ['font' => ['italic' => true, 'size' => 11]],
            7 => ['font' => ['bold' => true], 'fill' => ['fillType' => 'solid', 'startColor' => ['argb' => 'FFE2E8F0']]],
            $highestRow => [
                'font' => ['bold' => true, 'size' => 12],
                'fill' => ['fillType' => 'solid', 'startColor' => ['argb' => 'FFFFD1D1']],
            ],
            'C' => ['alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT]],
        ];
    }
}