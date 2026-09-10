<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengurus extends Model
{
    use HasFactory;

    protected $table = 'pengurus';

    protected $fillable = [
        'nama',
        'jabatan',
        'email',
        'telepon',
        'deskripsi',
        'foto',
        'urutan',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'urutan'    => 'integer',
    ];

    /**
     * Scope: hanya pengurus aktif, urut berdasarkan urutan.
     */
    public function scopeAktif($query)
    {
        return $query->where('is_active', true)->orderBy('urutan', 'asc');
    }

    /**
     * Accessor: URL foto.
     */
    public function getFotoUrlAttribute(): ?string
    {
        return $this->foto ? asset('storage/' . $this->foto) : null;
    }

    /**
     * Accessor: inisial nama (untuk fallback avatar).
     */
    public function getInisialAttribute(): string
    {
        return strtoupper(substr($this->nama ?? '?', 0, 1));
    }
}