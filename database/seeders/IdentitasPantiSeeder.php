<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\IdentitasPanti;

class IdentitasPantiSeeder extends Seeder
{
    public function run(): void
    {
        IdentitasPanti::updateOrCreate(
            ['nama_panti' => 'PIMPINAN RANTING MUHAMMADIYAH PESANTUNAN'], // unik
            [
                'nama_yayasan'   => 'Yayasan Kasih Anak Yatim',
                'nama_panti'     => 'LKSA PANTI ASUHAN MUHAMMADIYAH',
                'alamat'         => 'Jl.n. Teuku Cik Ditiro RT.01 / Rw. 08 Pesantunan - Wanasari - Brebes Brebes',
                'kota'           => 'Brebes',
                'kode_pos'       => '52212',
                'telepon'        => '081542054789',
                'email'          => 'info@muhammadiyah-pesantunan.or.id',
                'website'        => 'https://muhammadiyah-pesantunan.or.id',
                'pimpinan'       => 'H. Ahmad Subakhi, S.Ag',
                'bendahara'      => 'Siti Maimunah, S.E.',
                'npwp'           => '01.234.567.8-901.000',
                'no_rekening'    => '1234567890',
                'nama_bank'      => 'Bank Syariah Indonesia (BSI)',
                'logo'           => null,
            ]
        );
    }
}