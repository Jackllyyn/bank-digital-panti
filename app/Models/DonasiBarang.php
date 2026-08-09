<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class DonasiBarang extends Model
{
    use LogsActivity;

    protected $table = 'donasi_barang';

    protected $fillable = [
        'tanggal', 'no_transaksi', 'kode_donatur', 'kode_akun', 'keterangan', 'user_id'
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['*'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    public function donatur()
    {
        return $this->belongsTo(Donatur::class, 'kode_donatur', 'kode_donatur');
    }

    public function akun()
    {
        return $this->belongsTo(DaftarAkun::class, 'kode_akun', 'kode_akun');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function details()
    {
        return $this->hasMany(DonasiBarangDetail::class, 'donasi_barang_id');
    }
}