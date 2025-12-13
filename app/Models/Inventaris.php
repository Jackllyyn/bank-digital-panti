<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Inventaris extends Model
{
    use SoftDeletes, LogsActivity;

    protected $table = 'inventaris';
    protected $primaryKey = 'kode_barang';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'kode_barang', 'nama_barang', 'satuan', 'stok', 'harga_rata2', 'keterangan', 'foto'
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
        return "Inventaris telah {$eventName}";
    }

    public static function generateKode()
    {
        $last = self::orderBy('kode_barang', 'desc')->first();
        $number = $last ? (int)substr($last->kode_barang, 4) + 1 : 1;
        return 'INV-' . str_pad($number, 3, '0', STR_PAD_LEFT);
    }
}