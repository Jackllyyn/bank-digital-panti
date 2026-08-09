<?php

namespace App\Exports;

use App\Models\JurnalUmum;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class JurnalExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithColumnFormatting
{
    protected $startDate;
    protected $endDate;

    public function __construct($startDate = null, $endDate = null)
    {
        $this->startDate = $startDate;
        $this->endDate   = $endDate;
    }

    public function collection()
    {
        $query = JurnalUmum::with(['user', 'akunDebet', 'akunKredit']);

        if ($this->startDate && $this->endDate) {
            $query->whereBetween('tanggal', [$this->startDate, $this->endDate]);
        }

        return $query->orderBy('tanggal')->orderBy('no_transaksi')->get();
    }

    public function headings(): array
    {
        return [
            'Tanggal',
            'No Transaksi',
            'Uraian',
            'Akun Debet',
            'Debet (Rp)',
            'Akun Kredit',
            'Kredit (Rp)',
            'User Input',
        ];
    }

    public function map($jurnal): array
    {
        return [
            $jurnal->tanggal ? $jurnal->tanggal->format('d/m/Y') : '-',
            $jurnal->no_transaksi ?? '-',
            $jurnal->uraian ?? '-',
            $jurnal->akunDebet ? $jurnal->akunDebet->kode_akun . ' - ' . $jurnal->akunDebet->nama_akun : '-',
            $jurnal->akunDebet ? $jurnal->jumlah : 0,
            $jurnal->akunKredit ? $jurnal->akunKredit->kode_akun . ' - ' . $jurnal->akunKredit->nama_akun : '-',
            $jurnal->akunKredit ? $jurnal->jumlah : 0,
            $jurnal->user ? $jurnal->user->name : '-',
        ];
    }

    public function columnFormats(): array
    {
        return [
            'E' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1, // Debet
            'G' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1, // Kredit
        ];
    }
}