<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class AnakPanti extends Model
{
    use SoftDeletes, LogsActivity;

    protected $table = 'anak_panti';
    protected $primaryKey = 'niap';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'niap', 'nama', 'jenis_kelamin', 'kota', 'tempat_lahir',
        'tanggal_lahir', 'tanggal_masuk', 'status', 'nama_ayah',
        'nama_ibu', 'tingkat_pendidikan', 'nama_sekolah', 'foto'
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'tanggal_masuk' => 'date',
        'deleted_at'    => 'datetime',
    ];

    // ---------------------------------------------------
    // MUTATOR: Otomatis ubah ke huruf kapital awal saat disimpan
    // ---------------------------------------------------

    public function setNamaAttribute($value)
    {
        $this->attributes['nama'] = ucwords(strtolower($value));
    }

    public function setKotaAttribute($value)
    {
        $this->attributes['kota'] = ucwords(strtolower($value));
    }

    public function setTempatLahirAttribute($value)
    {
        $this->attributes['tempat_lahir'] = ucwords(strtolower($value));
    }

    public function setNamaAyahAttribute($value)
    {
        $this->attributes['nama_ayah'] = ucwords(strtolower($value));
    }

    public function setNamaIbuAttribute($value)
    {
        $this->attributes['nama_ibu'] = ucwords(strtolower($value));
    }

    public function setNamaSekolahAttribute($value)
    {
        $this->attributes['nama_sekolah'] = ucwords(strtolower($value));
    }

    public function setTingkatPendidikanAttribute($value)
    {
        $this->attributes['tingkat_pendidikan'] = strtoupper($value);
    }

    // ---------------------------------------------------
    // ACCESSOR: Untuk tampilan (tetap gunakan accessor yang sudah ada)
    // ---------------------------------------------------

    public function getNamaAttribute($value)
    {
        return ucwords(strtolower($value));
    }

    public function getKotaAttribute($value)
    {
        return ucwords(strtolower($value));
    }

    public function getTempatLahirAttribute($value)
    {
        return ucwords(strtolower($value));
    }

    public function getNamaAyahAttribute($value)
    {
        return ucwords(strtolower($value));
    }

    public function getNamaIbuAttribute($value)
    {
        return ucwords(strtolower($value));
    }

    public function getNamaSekolahAttribute($value)
    {
        return ucwords(strtolower($value));
    }

    public function getTingkatPendidikanAttribute($value)
    {
        return strtoupper($value);
    }

    public function getJenisKelaminDisplayAttribute()
    {
        return $this->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan';
    }

    public function getStatusDisplayAttribute()
    {
        return ucwords(str_replace('_', ' ', $this->status));
    }

    // ---------------------------------------------------
    // Activity Log (tetap seperti semula)
    // ---------------------------------------------------
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['*'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    public function getDescriptionForEvent(string $eventName): string
    {
        return "Data anak panti telah {$eventName}";
    }
}