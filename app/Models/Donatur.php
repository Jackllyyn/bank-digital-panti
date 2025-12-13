<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Donatur extends Model
{
    use SoftDeletes, LogsActivity;

    protected $table = 'donatur';
    protected $primaryKey = 'kode_donatur';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'kode_donatur',
        'jenis_donatur',
        'nama',
        'alamat_lengkap',
        'kota',
        'telepon',
        'jenis_kelamin',
        'pekerjaan',
        'klasifikasi',
        'tanggal_daftar'
    ];

    protected $casts = [
        'tanggal_daftar' => 'date:Y-m-d',
        'deleted_at'     => 'datetime',
    ];

    // MUTATOR: otomatis huruf kapital awal saat disimpan (manual & import)
    public function setNamaAttribute($value)
    {
        $this->attributes['nama'] = ucwords(strtolower($value));
    }

    public function setKotaAttribute($value)
    {
        $this->attributes['kota'] = ucwords(strtolower($value));
    }

    public function setJenisDonaturAttribute($value)
    {
        $this->attributes['jenis_donatur'] = ucwords(strtolower($value));
    }

    public function setPekerjaanAttribute($value)
    {
        $this->attributes['pekerjaan'] = ucwords(strtolower($value));
    }

    // ACCESSOR: tampilan rapi
    public function getNamaAttribute($value)
    {
        return ucwords(strtolower($value));
    }

    public function getKotaAttribute($value)
    {
        return ucwords(strtolower($value));
    }

    public function getJenisDonaturAttribute($value)
    {
        return ucwords(strtolower($value));
    }

    public function getPekerjaanAttribute($value)
    {
        return ucwords(strtolower($value));
    }

    public function getTanggalDaftarFormattedAttribute()
    {
        return $this->tanggal_daftar?->format('d/m/Y') ?? '-';
    }

    // Relasi & Total Donasi
    public function penerimaanDonasi()
    {
        return $this->hasMany(\App\Models\PenerimaanDonasi::class, 'kode_donatur', 'kode_donatur');
    }

    public function getTotalDonasiAttribute()
    {
        return $this->penerimaanDonasi()->sum('jumlah');
    }

    public function getTotalDonasiRpAttribute()
    {
        return $this->total_donasi > 0 
            ? 'Rp ' . number_format($this->total_donasi, 0, ',', '.') 
            : '-';
    }

    // Activity Log
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(fn(string $eventName) => "Donatur {$this->nama} telah {$eventName}");
    }
}