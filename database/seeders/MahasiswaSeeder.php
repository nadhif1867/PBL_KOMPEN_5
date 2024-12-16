<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class MahasiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id_mahasiswa' => 1,
                'id_level' => 4,
                'username' => 'kenneth',
                'password' => Hash::make('12345'),
                'nim' => '2241760001',
                'prodi'=> 'Sistem Informasi Bisnis',
                'email' => 'kenneth@gmail.com',
                'tahun_masuk' => 2022,
                'no_telepon' => '081233334444',
                'nama' => 'Kenneth',
                'avatar' => '',
                'kelas' => 'SIB 1C',
                'semester' => '1'
            ],
            [
                'id_mahasiswa' => 2,
                'id_level' => 4,
                'username' => 'brandon',
                'password' => Hash::make('12345'),
                'nim' => '2241760002',
                'prodi'=> 'Sistem Informasi Bisnis',
                'email' => 'brandon@gmail.com',
                'tahun_masuk' => 2022,
                'no_telepon' => '081255556666',
                'nama' => 'Brandon',
                'avatar' => '',
                'kelas' => 'SIB 1C',
                'semester' => '1'
            ],
            [
                'id_mahasiswa' => 3,
                'id_level' => 4,
                'username' => 'jocelyn',
                'password' => Hash::make('12345'),
                'nim' => '2241760003',
                'prodi'=> 'Sistem Informasi Bisnis',
                'email' => 'jocelyn@gmail.com',
                'tahun_masuk' => 2022,
                'no_telepon' => '081299998888',
                'nama' => 'Jocelyn',
                'avatar' => '',
                'kelas' => 'SIB 1C',
                'semester' => '1'
            ],
            [
                'id_mahasiswa' => 4,
                'id_level' => 4,
                'username' => 'aileen',
                'password' => Hash::make('12345'),
                'nim' => '2241760004',
                'prodi'=> 'Sistem Informasi Bisnis',
                'email' => 'aileen@gmail.com',
                'tahun_masuk' => 2022,
                'no_telepon' => '081299998888',
                'nama' => 'Aileen',
                'avatar' => '',
                'kelas' => 'SIB 1C',
                'semester' => '1'
            ],
        ];
        DB::table('m_mahasiswa')->insert($data);
    }
}
