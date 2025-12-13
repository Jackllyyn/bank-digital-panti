<?php

namespace App\Imports;

use App\Models\Donatur;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Carbon\Carbon;

class DonaturImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Generate kode jika kosong
        $kodeDonatur = $row['kode_donatur'] ?? null;
        if (!$kodeDonatur) {
            $last = Donatur::orderBy('kode_donatur', 'desc')->first();
            $next = $last ? (int)substr($last->kode_donatur, 1) + 1 : 1;
            $kodeDonatur = 'D' . str_pad($next, 3, '0', STR_PAD_LEFT);
        }

        // Cari atau buat baru
        $donatur = Donatur::firstOrNew(['kode_donatur' => $kodeDonatur]);

        // Parse tanggal (mendukung serial Excel)
        $tanggalDaftar = $this->parseDate($row['tanggal_daftar'] ?? null);

        $donatur->fill([
            'jenis_donatur'    => $row['jenis_donatur'] ?? null,
            'nama'             => $row['nama'],
            'alamat_lengkap'   => $row['alamat_lengkap'] ?? null,
            'kota'             => $row['kota'] ?? null,
            'telepon'          => $row['telepon'] ?? null,
            'jenis_kelamin'    => strtoupper($row['jenis_kelamin'] ?? null),
            'pekerjaan'        => $row['pekerjaan'] ?? null,
            'klasifikasi'      => $row['klasifikasi'] ?? 'tidak tetap',
            'tanggal_daftar'   => $tanggalDaftar,
        ]);

        $donatur->save();

        return $donatur;
    }

    protected function parseDate($value)
    {
        if (empty($value)) return null;

        // Sudah format Y-m-d
        if (is_string($value) && preg_match('/^\d{4}-\d{2}-\d{2}$/', $value)) {
            return $value;
        }

        // Format Indonesia DD/MM/YYYY
        if (is_string($value) && preg_match('/^\d{1,2}\/\d{1,2}\/\d{4}$/', $value)) {
            try {
                return Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
            } catch (\Exception $e) {
                // lanjut
            }
        }

        // Serial number Excel
        if (is_numeric($value) && $value > 40000) {
            try {
                return Carbon::createFromDate(1899, 12, 30)->addDays((int)$value)->format('Y-m-d');
            } catch (\Exception $e) {
                return null;
            }
        }

        try {
            return Carbon::parse($value)->format('Y-m-d');
        } catch (\Exception $e) {
            return null;
        }
    }
}