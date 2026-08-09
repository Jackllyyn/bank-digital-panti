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
            ['kode_akun' => '1001', 'nama_akun' => 'Kas', 'kelompok' => 'ASET', 'posisi_saldo' => 'DEBET', 'saldo_awal' => 0, 'tahun' => $tahun],
            ['kode_akun' => '1002', 'nama_akun' => 'Bank', 'kelompok' => 'ASET', 'posisi_saldo' => 'DEBET', 'saldo_awal' => 0, 'tahun' => $tahun],
            ['kode_akun' => '1003', 'nama_akun' => 'Kas Besar', 'kelompok' => 'ASET', 'posisi_saldo' => 'DEBET', 'saldo_awal' => 0, 'tahun' => $tahun],
            ['kode_akun' => '1004', 'nama_akun' => 'Kas Kecil', 'kelompok' => 'ASET', 'posisi_saldo' => 'DEBET', 'saldo_awal' => 0, 'tahun' => $tahun],
            ['kode_akun' => '1005', 'nama_akun' => 'Persediaan Barang', 'kelompok' => 'ASET', 'posisi_saldo' => 'DEBET', 'saldo_awal' => 0, 'tahun' => $tahun],
            ['kode_akun' => '2001', 'nama_akun' => 'Bangunan Panti', 'kelompok' => 'LIABILITAS', 'posisi_saldo' => 'KREDIT', 'saldo_awal' => 0, 'tahun' => $tahun],
            ['kode_akun' => '3001', 'nama_akun' => 'Aset Panti Tidak Terikat', 'kelompok' => 'EKUITAS', 'posisi_saldo' => 'KREDIT', 'saldo_awal' => 0, 'tahun' => $tahun],
            ['kode_akun' => '4001', 'nama_akun' => 'Donasi Zakat Fitrah', 'kelompok' => 'PENDAPATAN', 'posisi_saldo' => 'DEBET', 'saldo_awal' => 0, 'tahun' => $tahun],
            ['kode_akun' => '4002', 'nama_akun' => 'Donasi Zakat Mal', 'kelompok' => 'PENDAPATAN', 'posisi_saldo' => 'DEBET', 'saldo_awal' => 0, 'tahun' => $tahun],
            ['kode_akun' => '4003', 'nama_akun' => 'Infak/Sedekah', 'kelompok' => 'PENDAPATAN', 'posisi_saldo' => 'DEBET', 'saldo_awal' => 0, 'tahun' => $tahun],
            ['kode_akun' => '4004', 'nama_akun' => 'Wakaf', 'kelompok' => 'PENDAPATAN', 'posisi_saldo' => 'DEBET', 'saldo_awal' => 0, 'tahun' => $tahun],
            ['kode_akun' => '5001', 'nama_akun' => 'Biaya Makan & Minum Anak', 'kelompok' => 'BEBAN', 'posisi_saldo' => 'KREDIT', 'saldo_awal' => 0, 'tahun' => $tahun],
            ['kode_akun' => '5002', 'nama_akun' => 'Biaya Listrik, Air & Internet', 'kelompok' => 'BEBAN', 'posisi_saldo' => 'KREDIT', 'saldo_awal' => 0, 'tahun' => $tahun],
            ['kode_akun' => '5003', 'nama_akun' => 'Biaya Pendidikan & Seragam', 'kelompok' => 'BEBAN', 'posisi_saldo' => 'KREDIT', 'saldo_awal' => 0, 'tahun' => $tahun],
            ['kode_akun' => '5004', 'nama_akun' => 'Gaji Pengurus & Karyawan', 'kelompok' => 'BEBAN', 'posisi_saldo' => 'KREDIT', 'saldo_awal' => 0, 'tahun' => $tahun],
        ];

        foreach ($akun as $a) {
            DaftarAkun::updateOrCreate(
                ['kode_akun' => $a['kode_akun']],
                $a
            );
        }
    }
}