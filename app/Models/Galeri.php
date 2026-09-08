<?php
// app/Models/Galeri.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Galeri extends Model
{
    use HasFactory;

    protected $table = 'galeri';

    protected $fillable = [
        'judul',
        'slug',
        'kategori',
        'gambar',
        'deskripsi',
        'tanggal',
        'lokasi',
        'is_published',
        'views'
    ];

    protected $casts = [
        'tanggal' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'is_published' => 'boolean'
    ];
}