<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserRoleSeeder::class,
            RolePermissionSeeder::class,
            DaerahButuhRelawanSeeder::class,
            RelawanSeeder::class,
            LaporanSeeder::class,
            TanggapanSeeder::class,
        ]);
    }
}

