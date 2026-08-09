<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Carbon\Carbon;

class PenerimaanDonasiExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $donasis;

    public function __construct($donasis)
    {
        $this->donasis = $donasis;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->donasis;
    }

    public function headings(): array
    {
        return [
            'Tanggal',
            'No. Transaksi',
            'Nama Donatur',
            'Akun Pendapatan',
            'Keterangan',
            'Jumlah (Rp)',
            'Cara Bayar',
            'Dicatat Oleh',
        ];
    }

    public function map($donasi): array
    {
        return [
            $donasi->tanggal ? Carbon::parse($donasi->tanggal)->format('d/m/Y') : '',
            $donasi->no_transaksi,
            $donasi->donatur->nama ?? 'Umum / Hamba Allah',
            $donasi->akunPendapatan ? $donasi->akunPendapatan->kode_akun . ' - ' . $donasi->akunPendapatan->nama_akun : '-',
            $donasi->keterangan,
            $donasi->jumlah, // Dibiarkan angka mentah agar bisa di-sum di Excel
            ucfirst($donasi->cara_bayar),
            $donasi->user->name ?? '-',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]], // Baris pertama (Header) bold
        ];
    }
}