<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Barang extends Model
{
    use LogsActivity;

    protected $table = 'barang';

    protected $fillable = [
        'kode_barang',
        'nama_barang',
        'satuan',
        'kategori',
        'stok_saat_ini',
        'keterangan',
    ];

    protected $casts = [
        'stok_saat_ini' => 'integer',
        'created_at'    => 'datetime',
        'updated_at'    => 'datetime',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['*'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(fn(string $eventName) => "Barang {$this->nama_barang} ({$this->kode_barang}) telah {$eventName}");
    }

    // ─── Relasi ────────────────────────────────────────────────────────────────

    public function persediaanMasuk()
    {
        return $this->hasMany(PersediaanMasuk::class, 'barang_id');
    }

    public function persediaanKeluar()
    {
        return $this->hasMany(PersediaanKeluar::class, 'barang_id');
    }

    public function donasiBarangDetails()
    {
        return $this->hasMany(DonasiBarangDetail::class, 'barang_id');
    }

    // ─── Stok (semua integer) ─────────────────────────────────────────────────

    /**
     * Stok real-time: total masuk - total keluar (integer)
     */
    public function getStokRealAttribute(): int
    {
        $totalMasuk  = (int) $this->persediaanMasuk()->sum('qty');
        $totalKeluar = (int) $this->persediaanKeluar()->sum('qty');

        $stok = $totalMasuk - $totalKeluar;
        return max(0, $stok); // tidak boleh negatif
    }

    /**
     * Stok dari kolom master (jika masih digunakan)
     */
    public function getStokMasterAttribute(): int
    {
        return (int) ($this->stok_saat_ini ?? 0);
    }

    /**
     * Cek apakah stok cukup (integer comparison)
     */
    public function hasEnoughStock(int $qty): bool
    {
        return $this->stok_real >= $qty;
    }

    /**
     * Scope pencarian
     */
    public function scopeSearch($query, ?string $search = null)
    {
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('kode_barang', 'like', "%{$search}%")
                  ->orWhere('nama_barang', 'like', "%{$search}%");
            });
        }
        return $query;
    }
}