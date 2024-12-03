<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DetailBidKomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id_detail_bidkom' => 1,
                'id_mahasiswa' => 1,
                'id_bidkom' => 1
            ],
            [
                'id_detail_bidkom' => 2,
                'id_mahasiswa' => 2,
                'id_bidkom' => 2
            ],
            [
                'id_detail_bidkom' => 3,
                'id_mahasiswa' => 3,
                'id_bidkom' => 3
            ],
            [
                'id_detail_bidkom' => 4,
                'id_mahasiswa' => 4,
                'id_bidkom' => 4
            ]
        ];
        DB::table('t_detail_bidkom')->insert($data);
    }
}
