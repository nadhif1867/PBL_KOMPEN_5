<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DosenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id_dosen' => 1,
                'id_level' => 2,
                'username' => 'felix',
                'password' => Hash::make('12345'),
                'nip' => '199001012000011001',
                'no_telepon' => '081233334444',
                'email' => 'felix@gmail.com',
                'nama' => 'Felix',
                'avatar' => ''
            ],
            [
                'id_dosen' => 2,
                'id_level' => 2,
                'username' => 'dio',
                'password' => Hash::make('12345'),
                'nip' => '199001022000011002',
                'no_telepon' => '081255556666',
                'email' => 'dio@gmail.com',
                'nama' => 'Dio',
                'avatar' => ''
            ],
            [
                'id_dosen' => 3,
                'id_level' => 2,
                'username' => 'felicia',
                'password' => Hash::make('12345'),
                'nip' => '199001032000012003',
                'no_telepon' => '081299998888',
                'email' => 'felicia@gmail.com',
                'nama' => 'Felicia',
                'avatar' => ''
            ],
            [
                'id_dosen' => 4,
                'id_level' => 2,
                'username' => 'freya',
                'password' => Hash::make('12345'),
                'nip' => '199001042000012004',
                'no_telepon' => '081299998888',
                'email' => 'freya@gmail.com',
                'nama' => 'Freya',
                'avatar' => ''
            ],
        ];
        DB::table('m_dosen')->insert($data);
    }
}
