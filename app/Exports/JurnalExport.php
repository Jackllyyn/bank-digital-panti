<?php

namespace App\Exports;

use App\Models\JurnalUmum;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class JurnalExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return JurnalUmum::with(['user', 'akunDebet', 'akunKredit'])->get()->map(function ($j) {
            return [
                $j->tanggal->format('d/m/Y'),
                $j->no_transaksi,
                $j->uraian,
                $j->akunDebet ? $j->jumlah : 0,
                $j->akunKredit ? $j->jumlah : 0,
                $j->user->name,
            ];
        });
    }

    public function headings(): array
    {
        return ['Tanggal', 'No Transaksi', 'Uraian', 'Debet', 'Kredit', 'User'];
    }
}