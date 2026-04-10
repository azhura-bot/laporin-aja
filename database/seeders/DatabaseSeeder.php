<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Buat akun Admin
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@laporinaja.com',
            'password' => Hash::make('admin123'),
            'no_hp' => '081234567890',
            'role' => 'admin',
        ]);

        // Buat akun Admin kedua (opsional)
        User::create([
            'name' => 'Admin Utama',
            'email' => 'superadmin@laporinaja.com',
            'password' => Hash::make('admin123'),
            'no_hp' => '081298765432',
            'role' => 'admin',
        ]);

        // Buat akun User/Warga biasa
        User::create([
            'name' => 'Warga Test',
            'email' => 'warga@example.com',
            'password' => Hash::make('password'),
            'no_hp' => '081276543210',
            'role' => 'user',
        ]);

        // Buat akun Warga kedua (opsional)
        User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'password' => Hash::make('password'),
            'no_hp' => '081255512345',
            'role' => 'user',
        ]);

        // Seed daerah yang membutuhkan relawan
        $this->call(DaerahButuhRelawanSeeder::class);
    }
}