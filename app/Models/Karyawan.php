<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Karyawan extends Model
{
    use SoftDeletes, LogsActivity;

    protected $table = 'karyawan';
    protected $primaryKey = 'nip';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'nip',
        'jenis_karyawan',
        'nama',
        'alamat_lengkap',
        'kota',
        'telepon',
        'klasifikasi',
        'jenis_kelamin',
        'gaji_pokok',
        'tunjangan',
        'potongan_gaji',
        'jabatan',
        'tanggal_daftar'
    ];

    protected $casts = [
        'tanggal_daftar' => 'date:Y-m-d',
        'gaji_pokok'     => 'decimal:2',
        'tunjangan'      => 'decimal:2',
        'potongan_gaji'  => 'decimal:2',
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

    public function setJenisKaryawanAttribute($value)
    {
        $this->attributes['jenis_karyawan'] = ucwords(strtolower($value));
    }

    public function setJabatanAttribute($value)
    {
        $this->attributes['jabatan'] = ucwords(strtolower($value));
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

    public function getJabatanAttribute($value)
    {
        return ucwords(strtolower($value));
    }

    public function getTanggalDaftarFormattedAttribute()
    {
        return $this->tanggal_daftar?->format('d/m/Y') ?? '-';
    }

    // ACCESSOR: Gaji Bersih
    public function getGajiBersihAttribute()
    {
        return ($this->gaji_pokok ?? 0) + ($this->tunjangan ?? 0) - ($this->potongan_gaji ?? 0);
    }

    // ACCESSOR: Format Rupiah
    public function getGajiPokokRpAttribute()
    {
        return 'Rp ' . number_format($this->gaji_pokok ?? 0, 0, ',', '.');
    }

    public function getTunjanganRpAttribute()
    {
        return 'Rp ' . number_format($this->tunjangan ?? 0, 0, ',', '.');
    }

    public function getPotonganGajiRpAttribute()
    {
        return 'Rp ' . number_format($this->potongan_gaji ?? 0, 0, ',', '.');
    }

    public function getGajiBersihRpAttribute()
    {
        return 'Rp ' . number_format($this->gaji_bersih, 0, ',', '.');
    }

    // Relasi & Total Donasi
    public function kasBesar()
    {
        return $this->hasMany(\App\Models\KasBesar::class, 'nip', 'nip');
    }

    // Activity Log
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(fn(string $eventName) => "Karyawan {$this->nama} telah {$eventName}");
    }
}