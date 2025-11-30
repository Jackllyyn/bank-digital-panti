<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */public function run(): void
{
    \App\Models\User::create([
        'name' => 'Administrator',
        'email' => 'admin@panti.com',
        'password' => bcrypt('admin123'),
        'role' => 'admin',
    ]);

    \App\Models\User::create([
        'name' => 'Staff Keuangan',
        'email' => 'staff@panti.com',
        'password' => bcrypt('staff123'),
        'role' => 'staff',
    ]);
}
}
