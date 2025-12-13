<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class SaldoAwal extends Model
{
    use LogsActivity;

    protected $table = 'saldo_awal';

    protected $fillable = ['kode_akun', 'tahun', 'saldo'];

    protected $casts = [
        'saldo' => 'decimal:2',
        'tahun' => 'integer',
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
        return "Saldo awal telah {$eventName}";
    }

    public function akun()
    {
        return $this->belongsTo(DaftarAkun::class, 'kode_akun', 'kode_akun');
    }
}