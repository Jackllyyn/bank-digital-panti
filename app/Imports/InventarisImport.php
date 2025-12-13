<?php

namespace App\Imports;

use App\Models\Inventaris;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class InventarisImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $barang = Inventaris::firstOrNew(['kode_barang' => $row['kode_barang']]);

        $barang->fill([
            'nama_barang' => $row['nama_barang'],
            'satuan'      => $row['satuan'] ?? null,
            'stok'        => $row['stok'],
            'harga_rata2' => $row['harga_rata2'],
            'keterangan'  => $row['keterangan'] ?? null,
        ]);

        $barang->save();
        return $barang;
    }
}