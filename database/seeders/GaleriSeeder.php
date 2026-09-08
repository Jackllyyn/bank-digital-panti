<?php
// database/seeders/GaleriSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class GaleriSeeder extends Seeder
{
    public function run()
    {
        $galeri = [
            [
                'judul' => 'Kegiatan Belajar Mengajar di Ruang Kelas Digital',
                'slug' => 'kegiatan-belajar-mengajar-digital',
                'kategori' => 'Pendidikan',
                'gambar' => null,
                'deskripsi' => 'Anak-anak asuh sedang mengikuti pembelajaran digital dengan tablet yang didonasikan oleh para donatur.',
                'tanggal' => now()->subDays(5),
                'is_published' => true
            ],
            [
                'judul' => 'Makan Bergizi Bersama Anak Asuh',
                'slug' => 'makan-bergizi-bersama',
                'kategori' => 'Kegiatan',
                'gambar' => null,
                'deskripsi' => 'Momen kebersamaan saat makan siang bergizi bersama seluruh anak asuh dan pengurus panti.',
                'tanggal' => now()->subDays(10),
                'is_published' => true
            ],
            [
                'judul' => 'Kegiatan Olahraga Senam Pagi',
                'slug' => 'olahraga-senam-pagi',
                'kategori' => 'Kesehatan',
                'gambar' => null,
                'deskripsi' => 'Kegiatan senam pagi rutin untuk menjaga kesehatan dan kebugaran anak-anak asuh.',
                'tanggal' => now()->subDays(15),
                'is_published' => true
            ],
            [
                'judul' => 'Pengajian dan Tahfidz Al-Qur\'an',
                'slug' => 'pengajian-tahfidz',
                'kategori' => 'Keagamaan',
                'gambar' => null,
                'deskripsi' => 'Kegiatan pengajian dan tahfidz Al-Qur\'an yang diikuti oleh anak-anak asuh dengan penuh semangat.',
                'tanggal' => now()->subDays(20),
                'is_published' => true
            ],
            [
                'judul' => 'Penyaluran Donasi Buku Pelajaran',
                'slug' => 'penyaluran-donasi-buku',
                'kategori' => 'Donasi',
                'gambar' => null,
                'deskripsi' => 'Penyaluran buku pelajaran dan alat tulis dari donatur untuk mendukung program pendidikan anak asuh.',
                'tanggal' => now()->subDays(25),
                'is_published' => true
            ],
            [
                'judul' => 'Renovasi Asrama Putra dan Putri',
                'slug' => 'renovasi-asrama',
                'kategori' => 'Fasilitas',
                'gambar' => null,
                'deskripsi' => 'Proses renovasi asrama untuk meningkatkan kenyamanan dan fasilitas anak-anak asuh.',
                'tanggal' => now()->subDays(30),
                'is_published' => true
            ],
            [
                'judul' => 'Pelatihan Keterampilan Memasak',
                'slug' => 'pelatihan-memasak',
                'kategori' => 'Keterampilan',
                'gambar' => null,
                'deskripsi' => 'Pelatihan keterampilan memasak untuk bekal kemandirian anak-anak asuh di masa depan.',
                'tanggal' => now()->subDays(35),
                'is_published' => true
            ],
            [
                'judul' => 'Kunjungan ke Panti Asuhan Lain',
                'slug' => 'kunjungan-panti-lain',
                'kategori' => 'Sosial',
                'gambar' => null,
                'deskripsi' => 'Kunjungan silaturahmi ke panti asuhan lain untuk memperluas wawasan dan menjalin kerjasama.',
                'tanggal' => now()->subDays(40),
                'is_published' => true
            ]
        ];

        foreach ($galeri as $data) {
            DB::table('galeri')->insert($data);
        }
    }
}