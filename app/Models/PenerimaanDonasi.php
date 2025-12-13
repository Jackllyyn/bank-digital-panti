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
        'tanggal', 'kode_donatur', 'jenis', 'keterangan', 'jumlah', 'cara_bayar', 'user_id'
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
        return "Penerimaan donasi telah {$eventName}";
    }

    public function donatur(): BelongsTo
    {
        return $this->belongsTo(Donatur::class, 'kode_donatur', 'kode_donatur');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}