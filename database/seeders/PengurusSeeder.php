<?php
// database/seeders/PengurusSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pengurus;
use Illuminate\Support\Facades\DB;

class PengurusSeeder extends Seeder
{
    public function run()
    {
        // Hapus data lama (optional)
        DB::table('pengurus')->truncate();
        
        $pengurus = [
            [
                'nama' => 'H. Ahmad Subakhi, S.Ag',
                'jabatan' => 'Ketua Yayasan',
                'deskripsi' => 'Memimpin yayasan dengan dedikasi tinggi untuk kemajuan anak-anak asuh. Beliau memiliki pengalaman lebih dari 20 tahun di bidang pengasuhan dan pendidikan.',
                'email' => 'ahmad.subakhi@pampesantunan.or.id',
                'telepon' => '0812-3456-7890',
                'urutan' => 1,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nama' => 'Siti Maimunah, S.E.',
                'jabatan' => 'Bendahara',
                'deskripsi' => 'Mengelola keuangan yayasan dengan transparan dan profesional. Berpengalaman dalam akuntansi dan manajemen keuangan selama 15 tahun.',
                'email' => 'siti.maimunah@pampesantunan.or.id',
                'telepon' => '0812-3456-7891',
                'urutan' => 2,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nama' => 'Dr. H. Muhammad Yusuf, M.Pd',
                'jabatan' => 'Koordinator Pendidikan',
                'deskripsi' => 'Mengawasi program pendidikan dan pengembangan anak asuh. Memiliki pengalaman sebagai dosen dan pengelola pendidikan selama 18 tahun.',
                'email' => 'muhammad.yusuf@pampesantunan.or.id',
                'telepon' => '0812-3456-7892',
                'urutan' => 3,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nama' => 'Hj. Fatimah Zahra, S.Psi',
                'jabatan' => 'Kepala Pengasuhan',
                'deskripsi' => 'Bertanggung jawab atas program pengasuhan holistik anak-anak asuh. Berpengalaman sebagai psikolog anak dan konseling selama 12 tahun.',
                'email' => 'fatimah.zahra@pampesantunan.or.id',
                'telepon' => '0812-3456-7893',
                'urutan' => 4,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nama' => 'Ustadz Abdul Rahman, S.Ag',
                'jabatan' => 'Pembina Keagamaan',
                'deskripsi' => 'Membina aspek spiritual dan keagamaan anak-anak asuh. Hafidz Al-Qur\'an dan aktif dalam kegiatan dakwah.',
                'email' => 'abdul.rahman@pampesantunan.or.id',
                'telepon' => '0812-3456-7894',
                'urutan' => 5,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nama' => 'Ibu Rina Sari, S.KM',
                'jabatan' => 'Koordinator Kesehatan',
                'deskripsi' => 'Mengelola program kesehatan dan gizi anak-anak asuh. Berpengalaman di bidang kesehatan masyarakat dan gizi klinik.',
                'email' => 'rina.sari@pampesantunan.or.id',
                'telepon' => '0812-3456-7895',
                'urutan' => 6,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];

        foreach ($pengurus as $data) {
            Pengurus::create($data);
        }
    }
}