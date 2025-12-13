<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Pengeluaran extends Model
{
    use LogsActivity;

    protected $table = 'pengeluaran';

    protected $fillable = [
        'tanggal', 'kode_akun', 'keterangan', 'jumlah', 'no_bukti', 'user_id'
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
        return "Pengeluaran telah {$eventName}";
    }

    public function akun()
    {
        return $this->belongsTo(DaftarAkun::class, 'kode_akun', 'kode_akun');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}