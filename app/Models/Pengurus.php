<?php
// app/Models/Pengurus.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengurus extends Model
{
    // Tentukan nama tabel secara eksplisit
    protected $table = 'pengurus';
    
    protected $fillable = [
        'nama',
        'jabatan',
        'foto',
        'deskripsi',
        'email',
        'telepon',
        'urutan',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];
}