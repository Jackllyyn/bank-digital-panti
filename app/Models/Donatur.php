<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Donatur extends Model
{
    use SoftDeletes;

    protected $table = 'donatur';
    protected $primaryKey = 'kode_donatur';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'kode_donatur',
        'jenis_donatur',
        'nama',
        'alamat_lengkap',
        'kota',
        'telepon',
        'jenis_kelamin',
        'pekerjaan',
        'klasifikasi',
        'tanggal_daftar'
    ];

    
    protected $casts = [
        'tanggal_daftar' => 'date',        
        'deleted_at'     => 'datetime',
    ];

   
    public function getTanggalDaftarAttribute($value)
    {
        return $value ? \Carbon\Carbon::parse($value)->format('d-m-Y') : '-';
    }
}