<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Throwable;

class UserRoleSeeder extends Seeder
{
    /**
     * Seed user data for each available role.
     */
    public function run(): void
    {
        if (! Schema::hasColumn('users', 'role')) {
            return;
        }

        $hasNoHpColumn = Schema::hasColumn('users', 'no_hp');
        $hasStatusColumn = Schema::hasColumn('users', 'status');

        $usersByRole = [
            'admin' => [
                [
                    'name' => 'Administrator',
                    'email' => 'admin@laporinaja.com',
                    'password' => Hash::make('admin123'),
                    'no_hp' => '081234567890',
                    'status' => 'aktif',
                ],
                [
                    'name' => 'Admin Utama',
                    'email' => 'superadmin@laporinaja.com',
                    'password' => Hash::make('admin123'),
                    'no_hp' => '081298765432',
                    'status' => 'aktif',
                ],
            ],
            'operator' => [
                [
                    'name' => 'Operator Lapangan',
                    'email' => 'operator@laporinaja.com',
                    'password' => Hash::make('operator123'),
                    'no_hp' => '081277778888',
                    'status' => 'aktif',
                ],
            ],
            'user' => [
                [
                    'name' => 'Warga Test',
                    'email' => 'warga@example.com',
                    'password' => Hash::make('password'),
                    'no_hp' => '081276543210',
                    'status' => 'aktif',
                ],
                [
                    'name' => 'Budi Santoso',
                    'email' => 'budi@example.com',
                    'password' => Hash::make('password'),
                    'no_hp' => '081255512345',
                    'status' => 'aktif',
                ],
            ],
        ];

        $availableRoles = $this->availableRoles();

        foreach ($availableRoles as $role) {
            if (! isset($usersByRole[$role])) {
                continue;
            }

            foreach ($usersByRole[$role] as $userData) {
                $payload = [
                    'name' => $userData['name'],
                    'password' => $userData['password'],
                    'role' => $role,
                ];

                if ($hasNoHpColumn) {
                    $payload['no_hp'] = $userData['no_hp'];
                }

                if ($hasStatusColumn && isset($userData['status'])) {
                    $payload['status'] = $userData['status'];
                }

                User::updateOrCreate(
                    ['email' => $userData['email']],
                    $payload
                );
            }
        }
    }

    /**
     * Read allowed role values from users.role enum for MySQL/MariaDB.
     * Fallback to roles used by application logic when enum metadata is unavailable.
     *
     * @return array<int, string>
     */
    private function availableRoles(): array
    {
        try {
            $driver = DB::getDriverName();

            if (in_array($driver, ['mysql', 'mariadb'], true)) {
                $column = DB::selectOne("
                    SELECT COLUMN_TYPE AS column_type
                    FROM INFORMATION_SCHEMA.COLUMNS
                    WHERE TABLE_SCHEMA = DATABASE()
                        AND TABLE_NAME = 'users'
                        AND COLUMN_NAME = 'role'
                    LIMIT 1
                ");

                if ($column !== null && isset($column->column_type)) {
                    preg_match_all("/'([^']+)'/", $column->column_type, $matches);

                    if (! empty($matches[1])) {
                        return array_values(array_unique($matches[1]));
                    }
                }
            }
        } catch (Throwable) {
            // Ignore and use fallback roles below.
        }

        return ['admin', 'operator', 'user'];
    }
}

