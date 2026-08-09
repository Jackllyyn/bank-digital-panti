<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class PersediaanMasuk extends Model
{
    use LogsActivity;

    protected $table = 'persediaan_masuk';

    protected $fillable = [
        'tanggal',
        'no_transaksi',
        'barang_id',
        'qty',              // sekarang integer
        'harga_satuan',
        'total_harga',
        'keterangan',
        'user_id',
    ];

    protected $casts = [
        'tanggal'      => 'date',
        'qty'          => 'integer',
        'harga_satuan' => 'decimal:2',
        'total_harga'  => 'decimal:2',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['*'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(fn(string $eventName) => "Persediaan masuk {$this->no_transaksi} telah {$eventName}");
    }

    // ─── Relasi ────────────────────────────────────────────────────────────────

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'barang_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // ─── Boot: update stok & harga rata-rata ────────────────────────────────

    protected static function booted()
    {
        static::created(function ($masuk) {
            // Update stok barang (sekarang qty integer)
            $masuk->barang()->increment('stok_saat_ini', $masuk->qty);

            // Update harga rata-rata (tetap akurat meski qty integer)
            $barang = $masuk->barang;

            // Total qty & total harga sebelum transaksi ini
            $totalMasukSebelum = $barang->persediaanMasuk()
                ->where('id', '!=', $masuk->id)
                ->sum('total_harga');

            $totalQtySebelum = $barang->persediaanMasuk()
                ->where('id', '!=', $masuk->id)
                ->sum('qty');

            // Qty & total baru termasuk transaksi ini
            $qtyTotal = $totalQtySebelum + $masuk->qty;
            $totalHargaTotal = $totalMasukSebelum + $masuk->total_harga;

            // Update harga rata-rata
            $barang->update([
                'harga_beli_rata2' => $qtyTotal > 0 ? $totalHargaTotal / $qtyTotal : 0,
            ]);
        });
    }
    
}