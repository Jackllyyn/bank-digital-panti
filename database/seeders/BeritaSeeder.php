<?php
// database/seeders/BeritaSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BeritaSeeder extends Seeder
{
    public function run()
    {
        $berita = [
            [
                'judul' => 'PAM Pesantunan Menerima Kunjungan dari Dinas Sosial Kabupaten Brebes',
                'slug' => 'kunjungan-dinas-sosial-brebes',
                'konten' => 'Panti Asuhan Muhammadiyah Pesantunan menerima kunjungan dari Dinas Sosial Kabupaten Brebes untuk melakukan monitoring dan evaluasi program pengasuhan. Kunjungan ini bertujuan untuk memastikan kualitas pelayanan dan pengasuhan anak-anak asuh sesuai dengan standar yang ditetapkan.

Dinas Sosial memberikan apresiasi atas program-program inovatif yang telah dilaksanakan oleh PAM Pesantunan, terutama dalam hal transparansi keuangan dan pemanfaatan teknologi digital. Kepala Dinas Sosial menyampaikan bahwa PAM Pesantunan menjadi salah satu model panti asuhan yang berhasil mengimplementasikan sistem kas digital dengan baik.

Kunjungan ini juga diikuti dengan diskusi bersama pengurus panti mengenai rencana pengembangan program ke depan, termasuk peningkatan fasilitas dan kapasitas pengasuhan.',
                'kategori' => 'Berita',
                'gambar' => null,
                'penulis' => 'Admin',
                'is_published' => true,
                'published_at' => now()->subDays(5),
                'views' => 150
            ],
            [
                'judul' => 'PT. Maju Jaya Salurkan Donasi Pendidikan Rp 50.000.000',
                'slug' => 'donasi-pendidikan-pt-maju-jaya',
                'konten' => 'PT. Maju Jaya menyalurkan donasi pendidikan sebesar Rp 50.000.000 untuk mendukung program pendidikan anak-anak asuh di Panti Asuhan Muhammadiyah Pesantunan. Donasi ini merupakan bagian dari program Corporate Social Responsibility (CSR) perusahaan.

Donasi ini akan digunakan untuk membiayai biaya sekolah, seragam, perlengkapan belajar, dan kegiatan ekstrakurikuler anak-anak asuh. Penyerahan donasi dilakukan langsung oleh Direktur PT. Maju Jaya di kantor PAM Pesantunan.

Kami mengucapkan terima kasih yang sebesar-besarnya kepada PT. Maju Jaya atas kepercayaan dan dukungannya. Semoga menjadi amal jariyah yang bermanfaat.',
                'kategori' => 'Donasi',
                'gambar' => null,
                'penulis' => 'Admin',
                'is_published' => true,
                'published_at' => now()->subDays(10),
                'views' => 95
            ],
            [
                'judul' => 'Peringatan Tahun Baru Islam 1447 H di Panti Asuhan',
                'slug' => 'tahun-baru-islam-1447',
                'konten' => 'Panti Asuhan Muhammadiyah Pesantunan mengadakan peringatan Tahun Baru Islam 1447 H dengan berbagai kegiatan keagamaan dan perlombaan. Kegiatan ini diikuti oleh seluruh anak asuh dan pengurus panti dengan penuh semangat dan kebahagiaan.

Acara dimulai dengan pengajian bersama yang diisi oleh Ustadz Abdul Rahman, kemudian dilanjutkan dengan lomba-lomba Islami seperti lomba adzan, hafalan surat pendek, dan cerdas cermat Islam. Anak-anak asuh sangat antusias mengikuti setiap perlombaan.

Puncak acara adalah doa bersama untuk keselamatan dan keberkahan tahun baru Islam. Kami berharap di tahun yang baru ini, PAM Pesantunan semakin berkembang dan mampu memberikan pelayanan terbaik bagi anak-anak asuh.',
                'kategori' => 'Kegiatan',
                'gambar' => null,
                'penulis' => 'Admin',
                'is_published' => true,
                'published_at' => now()->subDays(15),
                'views' => 110
            ],
            [
                'judul' => 'Peluncuran Fitur Lacak Donasi di Website Resmi',
                'slug' => 'fitur-lacak-donasi',
                'konten' => 'PAM Pesantunan meluncurkan fitur baru di website resmi untuk memudahkan donatur melacak donasi mereka secara real-time. Fitur ini merupakan bentuk komitmen kami dalam mewujudkan transparansi penuh.

Donatur dapat melihat riwayat donasi, status penyaluran, dan laporan penggunaan dana secara detail. Fitur ini dapat diakses melalui menu "Lacak Donasi" di website www.pampesantunan.or.id.

Kami berharap fitur ini dapat meningkatkan kepercayaan donatur dan memudahkan masyarakat untuk melihat dampak dari setiap donasi yang telah disalurkan.',
                'kategori' => 'Sistem Digital',
                'gambar' => null,
                'penulis' => 'Admin',
                'is_published' => true,
                'published_at' => now()->subDays(20),
                'views' => 80
            ],
            [
                'judul' => 'Dua Anak Asuh Raih Beasiswa Penuh di Universitas Terkemuka',
                'slug' => 'beasiswa-universitas-terkemuka',
                'konten' => 'Kabar membahagiakan datang dari Panti Asuhan Muhammadiyah Pesantunan. Dua anak asuh berhasil meraih beasiswa penuh di dua universitas terkemuka di Indonesia.

Mereka adalah Ahmad Fauzi yang lolos beasiswa di Universitas Gadjah Mada dan Siti Nurhaliza yang lolos di Universitas Indonesia. Keduanya berhasil bersaing dengan ribuan pendaftar lainnya dan menunjukkan prestasi akademik yang membanggakan.

Prestasi ini tidak terlepas dari dukungan dan doa dari seluruh pengurus panti serta para donatur yang telah membantu biaya pendidikan mereka selama ini. Semoga prestasi ini menjadi motivasi bagi anak-anak asuh lainnya untuk terus berprestasi.',
                'kategori' => 'Prestasi',
                'gambar' => null,
                'penulis' => 'Admin',
                'is_published' => true,
                'published_at' => now()->subDays(25),
                'views' => 200
            ],
            [
                'judul' => 'Panen Raya Kebun Sayur Organik Anak Asuh',
                'slug' => 'panen-raya-kebun-sayur',
                'konten' => 'Kebun sayur organik yang dikelola oleh anak-anak asuh Panti Asuhan Muhammadiyah Pesantunan akhirnya memanen hasil yang memuaskan. Panen raya ini merupakan hasil kerja keras anak-anak asuh selama beberapa bulan terakhir.

Berbagai jenis sayuran seperti bayam, kangkung, cabai, dan tomat berhasil dipanen dan akan digunakan untuk memenuhi kebutuhan konsumsi sehari-hari panti. Kelebihan hasil panen akan dijual untuk menambah kas panti.

Program pertanian organik ini merupakan bagian dari program kemandirian ekonomi yang bertujuan melatih keterampilan anak-anak asuh di bidang pertanian dan kewirausahaan.',
                'kategori' => 'Kegiatan',
                'gambar' => null,
                'penulis' => 'Admin',
                'is_published' => true,
                'published_at' => now()->subDays(30),
                'views' => 75
            ]
        ];

        foreach ($berita as $data) {
            DB::table('berita')->insert($data);
        }
    }
}