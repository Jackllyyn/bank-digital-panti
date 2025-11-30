<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventaris extends Model
{
    protected $primaryKey = 'kode_barang';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'kode_barang', 'nama_barang', 'satuan', 'stok', 'harga_rata2', 'keterangan', 'foto'
    ];

    public function totalNilai()
    {
        return $this->stok * $this->harga_rata2;
    }
}