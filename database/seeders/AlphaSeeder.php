<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AlphaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id_alpha' => 1,
                'id_mahasiswa' => 1,
                'jumlah_alpha' => 7,
                'kompen_dibayar' => 3,
                'id_periode' => 5,
            ],
            [
                'id_alpha' => 2,
                'id_mahasiswa' => 2,
                'jumlah_alpha' => 12,
                'kompen_dibayar' => 6,
                'id_periode' => 5,
            ],
            [
                'id_alpha' => 3,
                'id_mahasiswa' => 3,
                'jumlah_alpha' => 2,
                'kompen_dibayar' => 1,
                'id_periode' => 5,
            ],
            [
                'id_alpha' => 4,
                'id_mahasiswa' => 4,
                'jumlah_alpha' => 16,
                'kompen_dibayar' => 4,
                'id_periode' => 5,
            ],
        ];
        DB::table('m_alpha')->insert($data);
    }
}
