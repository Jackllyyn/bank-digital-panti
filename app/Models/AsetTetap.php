<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AsetTetap extends Model
{
    protected $primaryKey = 'kode_aset';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'kode_aset', 'nama_aset', 'tanggal_perolehan', 'harga_perolehan',
        'masa_manfaat_tahun', 'nilai_residu', 'akumulasi_penyusutan',
        'keterangan', 'foto'
    ];

    public function nilaiBuku()
    {
        return $this->harga_perolehan - $this->akumulasi_penyusutan;
    }
}