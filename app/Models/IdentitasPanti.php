<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IdentitasPanti extends Model
{

    protected $table = 'identitas_panti';

    protected $fillable = [
        'nama_yayasan', 'nama_panti', 'alamat', 'kota', 'kode_pos',
        'telepon', 'email', 'website', 'pimpinan', 'bendahara',
        'npwp', 'no_rekening', 'nama_bank', 'logo'
    ];
}