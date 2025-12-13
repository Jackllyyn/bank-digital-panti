<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class DaftarAkun extends Model
{
    use LogsActivity;

    protected $table = 'daftar_akun';
    protected $primaryKey = 'kode_akun';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'kode_akun',
        'nama_akun',
        'kelompok',
        'posisi_saldo',
        'saldo_awal',
        'tahun'
    ];

    protected $casts = [
        'saldo_awal' => 'decimal:2',
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
        return "Daftar akun telah {$eventName}";
    }
    public function saldoAwal()
    {
        return $this->hasMany(SaldoAwal::class, 'kode_akun', 'kode_akun');
    }
}
