<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class PersediaanKeluar extends Model
{
    use LogsActivity;

    protected $table = 'persediaan_keluar';

    protected $fillable = [
        'tanggal',
        'no_transaksi',
        'barang_id',
        'qty',              // sekarang integer
        'keterangan',
        'user_id',
    ];

    protected $casts = [
        'tanggal' => 'date',
        // qty tidak dicast decimal lagi
        'qty'     => 'integer',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['*'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(fn(string $eventName) => "Persediaan keluar {$this->no_transaksi} telah {$eventName}");
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
}