<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TugasAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id_tugas_admin' => 1,
                'nama_tugas' => 'Penelitian Data Univ', 
                'deskripsi' => 'Meneliti data mahasiswa jurusan TI pada univ A', 
                'status' => 'dibuka', 
                'tanggal_mulai' => '2024-12-01', 
                'tanggal_selesai' => '2024-12-10', 
                'jam_kompen' => 4, 
                'kuota' => 2, 
                'id_bidkom' => 16, 
                'id_jenis_kompen' => 3, 
                'id_admin' => 1,
                'id_periode' => 5
            ]
        ];
        DB::table('tugas_admin')->insert($data);
    }
}
