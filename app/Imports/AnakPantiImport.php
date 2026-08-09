<?php

namespace App\Imports;

use App\Models\AnakPanti;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class AnakPantiImport implements ToModel, WithHeadingRow, WithUpserts
{
    public function model(array $row)
    {
        // Generate NIAP jika kosong
        $niap = $row['niap'] ?? null;
        if (!$niap) {
            $last = AnakPanti::orderBy('niap', 'desc')->first();
            $next = $last ? (int)substr($last->niap, 1) + 1 : 1;
            $niap = 'A' . str_pad($next, 3, '0', STR_PAD_LEFT);
        }

        // Penanganan tanggal khusus untuk format Excel serial number
        $tanggalLahir = $this->transformDate($row['tanggal_lahir'] ?? null);
        $tanggalMasuk = $this->transformDate($row['tanggal_masuk'] ?? null);

        // Normalisasi status (agar 'tidak aktif' jadi 'keluar' atau sesuai kebutuhan)
        $status = strtolower(trim($row['status'] ?? 'aktif'));
        if (in_array($status, ['tidak aktif', 'non aktif', 'nonaktif'])) {
            $status = 'keluar';
        }

        return AnakPanti::updateOrCreate(
            ['niap' => $niap],
            [
                'nama'              => $row['nama'] ?? null,
                'jenis_kelamin'     => strtoupper($row['jenis_kelamin'] ?? null),
                'kota'              => $row['kota'] ?? null,
                'tempat_lahir'      => $row['tempat_lahir'] ?? null,
                'tanggal_lahir'     => $tanggalLahir,
                'tanggal_masuk'     => $tanggalMasuk,
                'status'            => $status,
                'nama_ayah'         => $row['nama_ayah'] ?? null,
                'nama_ibu'          => $row['nama_ibu'] ?? null,
                'tingkat_pendidikan'=> $row['tingkat_pendidikan'] ?? null,
                'nama_sekolah'      => $row['nama_sekolah'] ?? null,
            ]
        );
    }

    /**
     * Mengubah nilai tanggal Excel (serial number) menjadi Y-m-d
     */
    protected function transformDate($value)
    {
        if (empty($value)) return null;

        try {
            // Jika format angka (Excel Serial Date)
            if (is_numeric($value)) {
                return Date::excelToDateTimeObject($value)->format('Y-m-d');
            }
            
            // Jika format string
            return Carbon::parse($value)->format('Y-m-d');
        } catch (\Exception $e) {
            return null;
        }
    }

    public function uniqueBy()
    {
        return 'niap';
    }
}