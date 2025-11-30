<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnakAsuh extends Model
{
    protected $primaryKey = 'niap';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'niap', 'nama', 'jenis_kelamin', 'tempat_lahir', 'tanggal_lahir',
        'tanggal_masuk', 'alamat_asal', 'status', 'tingkat_pendidikan',
        'nama_sekolah', 'foto'
    ];

    protected $dates = ['tanggal_lahir', 'tanggal_masuk'];
}