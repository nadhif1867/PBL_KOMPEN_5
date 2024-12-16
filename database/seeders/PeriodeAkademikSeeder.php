<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PeriodeAkademikSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id_periode' => 1,
                'semester' => 'ganjil',
                'tahun_ajaran' => 2022,
                'status' => 'ditutup'
            ],
            [
                'id_periode' => 2,
                'semester' => 'genap',
                'tahun_ajaran' => 2022,
                'status' => 'ditutup'
            ],
            [
                'id_periode' => 3,
                'semester' => 'ganjil',
                'tahun_ajaran' => 2023,
                'status' => 'ditutup'
            ],
            [
                'id_periode' => 4,
                'semester' => 'genap',
                'tahun_ajaran' => 2023,
                'status' => 'ditutup'
            ],
            [
                'id_periode' => 5,
                'semester' => 'ganjil',
                'tahun_ajaran' => 2024,
                'status' => 'dibuka'
            ],
            [
                'id_periode' => 6,
                'semester' => 'genap',
                'tahun_ajaran' => 2024,
                'status' => 'ditutup'
            ],
        ];
        DB::table('m_periode_akademik')->insert($data);
    }
}
