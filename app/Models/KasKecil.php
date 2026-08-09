<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class KasKecil extends Model
{
    use LogsActivity;

    protected $table = 'kaskecil';

    protected $fillable = [
        'no_transaksi',
        'tanggal',  
        'keterangan',
        'kode_akund', 
        'kode_akunk', 
        'no_bukti', 
        'jumlah', 
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
        return "Transaksi kas kecil [{$this->no_transaksi}] telah {$eventName}";
    }

    // Relasi ke Akun Debet
    public function akunDebet(): BelongsTo
    {
        return $this->belongsTo(DaftarAkun::class, 'kode_akund', 'kode_akun');
    }

    // Relasi ke Akun Kredit
    public function akunKredit(): BelongsTo
    {
        return $this->belongsTo(DaftarAkun::class, 'kode_akunk', 'kode_akun');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
