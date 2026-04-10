<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\DaerahButuhRelawan;

class DaerahButuhRelawanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $daerahData = [
            [
                'nama_daerah' => 'Jakarta Pusat',
                'provinsi' => 'DKI Jakarta',
                'deskripsi' => 'Daerah pusat kota yang membutuhkan relawan untuk penanganan bencana banjir dan kebakaran',
                'prioritas' => 'tinggi',
                'relawan_dibutuhkan' => 50,
                'relawan_terdaftar' => 15,
                'aktif' => true,
            ],
            [
                'nama_daerah' => 'Bandung',
                'provinsi' => 'Jawa Barat',
                'deskripsi' => 'Kota Bandung membutuhkan relawan untuk mitigasi bencana tanah longsor',
                'prioritas' => 'kritis',
                'relawan_dibutuhkan' => 75,
                'relawan_terdaftar' => 20,
                'aktif' => true,
            ],
            [
                'nama_daerah' => 'Surabaya',
                'provinsi' => 'Jawa Timur',
                'deskripsi' => 'Daerah pesisir yang rawan tsunami dan banjir rob',
                'prioritas' => 'tinggi',
                'relawan_dibutuhkan' => 60,
                'relawan_terdaftar' => 25,
                'aktif' => true,
            ],
            [
                'nama_daerah' => 'Yogyakarta',
                'provinsi' => 'DI Yogyakarta',
                'deskripsi' => 'Daerah rawan gempa bumi dan erupsi gunung berapi',
                'prioritas' => 'kritis',
                'relawan_dibutuhkan' => 80,
                'relawan_terdaftar' => 30,
                'aktif' => true,
            ],
            [
                'nama_daerah' => 'Medan',
                'provinsi' => 'Sumatera Utara',
                'deskripsi' => 'Daerah yang sering mengalami banjir dan kebakaran hutan',
                'prioritas' => 'sedang',
                'relawan_dibutuhkan' => 40,
                'relawan_terdaftar' => 10,
                'aktif' => true,
            ],
            [
                'nama_daerah' => 'Makassar',
                'provinsi' => 'Sulawesi Selatan',
                'deskripsi' => 'Daerah pesisir yang membutuhkan relawan SAR laut',
                'prioritas' => 'sedang',
                'relawan_dibutuhkan' => 35,
                'relawan_terdaftar' => 8,
                'aktif' => true,
            ],
            [
                'nama_daerah' => 'Palembang',
                'provinsi' => 'Sumatera Selatan',
                'deskripsi' => 'Daerah sungai yang rawan banjir tahunan',
                'prioritas' => 'tinggi',
                'relawan_dibutuhkan' => 45,
                'relawan_terdaftar' => 12,
                'aktif' => true,
            ],
            [
                'nama_daerah' => 'Semarang',
                'provinsi' => 'Jawa Tengah',
                'deskripsi' => 'Daerah pesisir utara yang rawan abrasi pantai',
                'prioritas' => 'sedang',
                'relawan_dibutuhkan' => 30,
                'relawan_terdaftar' => 5,
                'aktif' => true,
            ],
        ];

        foreach ($daerahData as $daerah) {
            DaerahButuhRelawan::create($daerah);
        }
    }
}
