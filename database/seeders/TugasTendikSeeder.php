<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TugasTendikSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id_tugas_tendik' => 1,
                'nama_tugas' => 'Setting LAN',
                'deskripsi' => 'Setting LAN pada ruang kelas',
                'status' => 'dibuka',
                'tanggal_mulai' => '2024-12-14',
                'tanggal_selesai' => '2024-12-24',
                'jam_kompen' => 3,
                'kuota' => 2,
                'id_bidkom' => 7,
                'id_jenis_kompen' => 1,
                'id_tendik' => 1,
                'id_periode' => 5
            ]
        ];
        DB::table('tugas_tendik')->insert($data);
    }
}
