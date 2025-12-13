<?php

namespace App\Imports;

use App\Models\AsetTetap;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AsetTetapImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $aset = AsetTetap::firstOrNew(['kode_aset' => $row['kode_aset']]);

        $aset->fill([
            'nama_aset'          => $row['nama_aset'],
            'tanggal_perolehan'  => $row['tanggal_perolehan'],
            'harga_perolehan'    => $row['harga_perolehan'],
            'masa_manfaat_tahun' => $row['masa_manfaat_tahun'] ?? null,
            'nilai_residu'       => $row['nilai_residu'] ?? null,
            'keterangan'         => $row['keterangan'] ?? null,
        ]);

        $aset->save();
        return $aset;
    }
}