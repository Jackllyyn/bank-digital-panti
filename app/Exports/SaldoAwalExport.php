<?php

namespace App\Exports;

use App\Models\DaftarAkun;
use App\Models\SaldoAwal;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SaldoAwalExport implements FromCollection, WithHeadings, WithStyles, WithTitle
{
    protected $kelompok;
    protected $tahun;

    public function __construct($kelompok = null)
    {
        $this->kelompok = $kelompok;
        $this->tahun = date('Y');
    }

    public function collection()
    {
        $query = DaftarAkun::select('kode_akun', 'nama_akun', 'kelompok', 'posisi_saldo')
            ->orderBy('kode_akun');

        if ($this->kelompok) {
            $query->where('kelompok', $this->kelompok);
        }

        $akuns = $query->get();
        $saldoAwal = SaldoAwal::where('tahun', $this->tahun)
            ->pluck('saldo', 'kode_akun')
            ->toArray();

        return $akuns->map(function ($akun) use ($saldoAwal) {
            return [
                'Kode Akun'       => $akun->kode_akun,
                'Nama Akun'       => $akun->nama_akun,
                'Kelompok'        => $akun->kelompok,
                'Posisi Normal'   => $akun->posisi_saldo,
                'Saldo Awal (Rp)' => $saldoAwal[$akun->kode_akun] ?? 0,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Kode Akun',
            'Nama Akun',
            'Kelompok',
            'Posisi Normal',
            'Saldo Awal Tahun ' . $this->tahun
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:E1')->getFont()->setBold(true);
        $sheet->getStyle('E')->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(45);
        $sheet->getColumnDimension('C')->setWidth(15);
        $sheet->getColumnDimension('D')->setWidth(14);
        $sheet->getColumnDimension('E')->setWidth(22);
    }

    public function title(): string
    {
        return $this->kelompok ? $this->kelompok : 'Semua Kelompok';
    }
}