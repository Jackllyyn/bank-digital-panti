<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class PenerimaanDonasi extends Model
{
    use LogsActivity;

    protected $table = 'penerimaan_donasi';

    protected $fillable = [
        'no_transaksi',
        'tanggal',
        'kode_donatur',
        'kode_pendapatan',
        'keterangan',
        'jumlah',
        'cara_bayar',
        'user_id'
    ];

    protected $casts = [
        'tanggal' => 'date',
        'jumlah'  => 'decimal:2',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['*'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    public function getDescriptionForEvent(string $eventName): string
    {
        return "Penerimaan donasi {$this->no_transaksi} telah {$eventName}";
    }

    public function donatur(): BelongsTo
    {
        return $this->belongsTo(Donatur::class, 'kode_donatur', 'kode_donatur');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Relasi baru
    public function akunPendapatan(): BelongsTo
    {
        return $this->belongsTo(DaftarAkun::class, 'kode_pendapatan', 'kode_akun');
    }

    /**
     * Scope a query to only include donations based on filters.
     * @param Builder
     * @param  array
     * @return Builder
     */
    public function scopeFilter($query, array $filters)
    {
        // Filter Tanggal
        $query->when($filters['dari'] ?? null, function ($query, $dari) {
            $query->whereDate('tanggal', '>=', $dari);
        });

        $query->when($filters['sampai'] ?? null, function ($query, $sampai) {
            $query->whereDate('tanggal', '<=', $sampai);
        });

        // Filter Akun Pendapatan
        $query->when($filters['kode_pendapatan'] ?? null, function ($query, $kode_pendapatan) {
            $query->where('kode_pendapatan', $kode_pendapatan);
        });

        // Filter Donatur (khusus handling untuk "umum")
        $query->when($filters['kode_donatur'] ?? null, function ($query, $kode_donatur) {
            if ($kode_donatur === 'umum') {
                return $query->whereNull('kode_donatur');
            }
            return $query->where('kode_donatur', $kode_donatur);
        });

        // Filter Cara Bayar
        $query->when($filters['cara_bayar'] ?? null, fn($query, $cara_bayar) => $query->where('cara_bayar', $cara_bayar));
    }
}