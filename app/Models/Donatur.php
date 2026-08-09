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
        'tanggal_daftar',
        'total_qty_donasi_barang',
        'total_nilai_donasi_barang',
        'total_donasi',
    ];

    protected $casts = [
        'tanggal_daftar'            => 'date:Y-m-d',
        'deleted_at'                => 'datetime',
        'total_qty_donasi_barang'   => 'decimal:2',
        'total_nilai_donasi_barang' => 'decimal:2',
        'total_donasi'              => 'decimal:2',
    ];

    public function setNamaAttribute($value)
    {
        $this->attributes['nama'] = ucwords(strtolower($value));
    }

    public function setKotaAttribute($value)
    {
        $this->attributes['kota'] = ucwords(strtolower($value));
    }

    public function getTanggalDaftarFormattedAttribute()
    {
        return $this->tanggal_daftar?->translatedFormat('d F Y') ?? '-';
    }

    public function getJenisDonaturDisplayAttribute()
    {
        return $this->jenis_donatur
            ? ($this->jenis_donatur === 'individu' ? 'Individu' : 'Organisasi')
            : '-';
    }

    public function getTotalQtyDonasiBarangFormattedAttribute()
    {
        $qty = $this->total_qty_donasi_barang ?? 0;
        return number_format($qty, 2, ',', '.');
    }

    public function getTotalNilaiDonasiBarangFormattedAttribute()
    {
        $nilai = $this->total_nilai_donasi_barang ?? 0;
        return $nilai > 0
            ? 'Rp ' . number_format($nilai, 0, ',', '.')
            : 'Rp 0';
    }

    // -------------------------------------------------------------------------
    // TERAKHIR DONASI
    // -------------------------------------------------------------------------
    public function getTerakhirDonasiAttribute()
    {
        // 1. Cek Donasi Uang (Prioritas attribute dari withMax)
        $lastMoney = $this->attributes['penerimaan_donasi_max_tanggal'] 
            ?? $this->penerimaanDonasi()->max('tanggal');

        // 2. Cek Donasi Barang
        $lastGoods = $this->attributes['donasi_barang_max_tanggal'] 
            ?? $this->donasiBarang()->max('tanggal');

        // 3. Bandingkan mana yang lebih baru
        if ($lastMoney && $lastGoods) {
            return $lastMoney > $lastGoods ? $lastMoney : $lastGoods;
        }
        return $lastMoney ?? $lastGoods;
    }

    public function getTerakhirDonasiFormattedAttribute()
    {
        $date = $this->terakhir_donasi;
        return $date ? \Carbon\Carbon::parse($date)->translatedFormat('d F Y') : '-';
    }

    // TOTAL DONASI UANG
    public function getTotalDonasiAttribute($value)
    {
        if ($this->relationLoaded('penerimaanDonasi')) {
            return (float) $this->penerimaanDonasi->sum('jumlah');
        }

        return (float) ($value ?? 0);
    }

    // TOTAL DONASI BARANG (QTY & NILAI)
    public function getTotalQtyDonasiBarangAttribute($value)
    {
        if ($value !== null) {
            return (float) $value;
        }

        return (float) $this->donasiBarang()
            ->join('donasi_barang_detail', 'donasi_barang.id', '=', 'donasi_barang_detail.donasi_barang_id')
            ->sum('donasi_barang_detail.qty');
    }

    public function getTotalNilaiDonasiBarangAttribute($value)
    {
        if ($value !== null) {
            return (float) $value;
        }

        return (float) $this->donasiBarang()
            ->join('donasi_barang_detail', 'donasi_barang.id', '=', 'donasi_barang_detail.donasi_barang_id')
            ->sum('donasi_barang_detail.total_nilai');
    }

    public function getTotalDonasiRpAttribute()
    {
        $jumlah = $this->total_donasi;
        return $jumlah > 0
            ? 'Rp ' . number_format($jumlah, 0, ',', '.')
            : 'Rp 0';
    }

    // GRAND TOTAL (UANG + BARANG)
    public function getTotalKeseluruhanAttribute()
    {
        return $this->total_donasi + $this->total_nilai_donasi_barang;
    }

    public function getTotalKeseluruhanRpAttribute()
    {
        $total = $this->total_keseluruhan;
        return $total > 0
            ? 'Rp ' . number_format($total, 0, ',', '.')
            : 'Rp 0';
    }

    // RELASI
    public function penerimaanDonasi()
    {
        return $this->hasMany(\App\Models\PenerimaanDonasi::class, 'kode_donatur', 'kode_donatur');
    }

    public function donasiBarang()
    {
        return $this->hasMany(\App\Models\DonasiBarang::class, 'kode_donatur', 'kode_donatur');
    }

    // ACTIVITY LOG
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(fn(string $eventName) => "Donatur {$this->nama} telah {$eventName}");
    }
}