<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JenisKompenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id_jenis_kompen' => 1,
                'jenis_kompen' => 'Teknis'
            ],
            [
                'id_jenis_kompen' => 2,
                'jenis_kompen' => 'Pengabdian'
            ],
            [
                'id_jenis_kompen' => 3,
                'jenis_kompen' => 'Penelitian',
            ],
        ];
        DB::table('m_jenis_kompen')->insert($data);
    }
}
