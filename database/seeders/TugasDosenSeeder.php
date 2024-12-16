<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TugasDosenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id_tugas_dosen' => 1,
                'nama_tugas' => 'Buat Tampilan Login',
                'deskripsi' => 'Membuat tampilan login untuk sistem kompen',
                'status' => 'dibuka',
                'tanggal_mulai' => '2024-12-05',
                'tanggal_selesai' => '2024-12-10',
                'jam_kompen' => 2,
                'kuota' => 1,
                'id_bidkom' => 4,
                'id_jenis_kompen' => 1,
                'id_dosen' => 1,
                'id_periode' => 5
            ]
        ];
        DB::table('tugas_dosen')->insert($data);
    }
}
