<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\IdentitasPanti;

class IdentitasPantiSeeder extends Seeder
{
    public function run(): void
    {
        IdentitasPanti::updateOrCreate(
            ['nama_panti' => 'Panti Muhammadiyah Pesantunan'], // unik
            [
                'nama_yayasan'   => 'Yayasan Kasih Anak Yatim',
                'nama_panti'     => 'Panti Muhammadiyah Pesantunan',
                'alamat'         => 'Jl. Brebes No. 123, Brebes',
                'kota'           => 'Brebes',
                'kode_pos'       => '52211',
                'telepon'        => '0283-1234567',
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