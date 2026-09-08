<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            IdentitasPantiSeeder::class,
            DaftarAkunSeeder::class,
            PengurusSeeder::class,
            GaleriSeeder::class,
            BeritaSeeder::class,
        ]);
    }
}