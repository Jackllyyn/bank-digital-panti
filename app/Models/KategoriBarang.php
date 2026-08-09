<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class KategoriBarang extends Model
{
    use LogsActivity;

    protected $table = 'kategori_barang';

    protected $fillable = [
        'nama_kategori',
        'deskripsi',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['*'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(fn(string $eventName) => "Kategori barang {$this->nama_kategori} telah {$eventName}");
    }

    public function barang()
    {
        return $this->hasMany(Barang::class, 'kategori_id');
    }
}