<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class AsetTetap extends Model
{
    use LogsActivity;

    protected $table = 'aset_tetap';
    protected $primaryKey = 'kode_aset';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'kode_aset', 'nama_aset', 'tanggal_perolehan', 'harga_perolehan',
        'masa_manfaat_tahun', 'nilai_residu', 'akumulasi_penyusutan',
        'keterangan', 'foto'
    ];

    protected $casts = [
        'tanggal_perolehan' => 'date',
        'harga_perolehan'   => 'decimal:2',
        'nilai_residu'      => 'decimal:2',
        'akumulasi_penyusutan' => 'decimal:2',
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
        return "Aset tetap telah {$eventName}";
    }

    public function nilaiBuku()
    {
        return $this->harga_perolehan - $this->akumulasi_penyusutan;
    }
}