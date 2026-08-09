<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DonasiBarangDetail extends Model
{
    protected $table = 'donasi_barang_detail';

    protected $fillable = [
        'donasi_barang_id', 'barang_id', 'qty', 'deskripsi_barang', 'nilai_satuan','total_nilai'
    ];

    public function donasi()
    {
        return $this->belongsTo(DonasiBarang::class, 'donasi_barang_id');
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }
}