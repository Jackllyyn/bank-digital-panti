<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DaftarAkun;

class DaftarAkunSeeder extends Seeder
{
    public function run(): void
    {
        $tahun = now()->year; 

        $akun = [
            ['kode_akun' => '101', 'nama_akun' => 'Kas', 'kelompok' => 'ASET', 'posisi_saldo' => 'DEBET', 'saldo_awal' => 50000000.00, 'tahun' => $tahun],
            ['kode_akun' => '102', 'nama_akun' => 'Bank BCA', 'kelompok' => 'ASET', 'posisi_saldo' => 'DEBET', 'saldo_awal' => 75000000.00, 'tahun' => $tahun],
            ['kode_akun' => '103', 'nama_akun' => 'Bank BSI', 'kelompok' => 'ASET', 'posisi_saldo' => 'DEBET', 'saldo_awal' => 30000000.00, 'tahun' => $tahun],
            ['kode_akun' => '201', 'nama_akun' => 'Hutang Operasional', 'kelompok' => 'LIABILITAS', 'posisi_saldo' => 'KREDIT', 'saldo_awal' => 5000000.00, 'tahun' => $tahun],
            ['kode_akun' => '301', 'nama_akun' => 'Modal Yayasan', 'kelompok' => 'EKUITAS', 'posisi_saldo' => 'KREDIT', 'saldo_awal' => 100000000.00, 'tahun' => $tahun],
            ['kode_akun' => '401', 'nama_akun' => 'Donasi Zakat Fitrah', 'kelompok' => 'PENDAPATAN', 'posisi_saldo' => 'KREDIT', 'saldo_awal' => 0, 'tahun' => $tahun],
            ['kode_akun' => '402', 'nama_akun' => 'Donasi Zakat Mal', 'kelompok' => 'PENDAPATAN', 'posisi_saldo' => 'KREDIT', 'saldo_awal' => 0, 'tahun' => $tahun],
            ['kode_akun' => '403', 'nama_akun' => 'Infak/Sedekah', 'kelompok' => 'PENDAPATAN', 'posisi_saldo' => 'KREDIT', 'saldo_awal' => 0, 'tahun' => $tahun],
            ['kode_akun' => '404', 'nama_akun' => 'Wakaf', 'kelompok' => 'PENDAPATAN', 'posisi_saldo' => 'KREDIT', 'saldo_awal' => 0, 'tahun' => $tahun],
            ['kode_akun' => '501', 'nama_akun' => 'Biaya Makan & Minum Anak', 'kelompok' => 'BEBAN', 'posisi_saldo' => 'DEBET', 'saldo_awal' => 0, 'tahun' => $tahun],
            ['kode_akun' => '502', 'nama_akun' => 'Biaya Listrik, Air & Internet', 'kelompok' => 'BEBAN', 'posisi_saldo' => 'DEBET', 'saldo_awal' => 0, 'tahun' => $tahun],
            ['kode_akun' => '503', 'nama_akun' => 'Biaya Pendidikan & Seragam', 'kelompok' => 'BEBAN', 'posisi_saldo' => 'DEBET', 'saldo_awal' => 0, 'tahun' => $tahun],
            ['kode_akun' => '504', 'nama_akun' => 'Gaji Pengurus & Karyawan', 'kelompok' => 'BEBAN', 'posisi_saldo' => 'DEBET', 'saldo_awal' => 0, 'tahun' => $tahun],
        ];

        foreach ($akun as $a) {
            DaftarAkun::updateOrCreate(
                ['kode_akun' => $a['kode_akun']],
                $a
            );
        }
    }
}