<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JurnalUmum extends Model
{

    protected $table = 'jurnal_umum';

    protected $fillable = [
        'tanggal',
        'no_transaksi',
        'no_bukti',
        'uraian',
        'kode_akun_debet',
        'kode_akun_kredit',
        'jumlah',
        'user_id',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'jumlah'  => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function akunDebet(): BelongsTo
    {
        return $this->belongsTo(DaftarAkun::class, 'kode_akun_debet', 'kode_akun');
    }

    public function akunKredit(): BelongsTo
    {
        return $this->belongsTo(DaftarAkun::class, 'kode_akun_kredit', 'kode_akun');
    }
}