<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TendikSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id_tendik' => 1,
                'id_level' => 3,
                'username' => 'andrew',
                'password' => Hash::make('12345'),
                'nip' => '199101012000011001',
                'no_telepon' => '081233334444',
                'email' => 'andrew@gmail.com',
                'nama' => 'Andrew',
                'avatar' => ''
            ],
            [
                'id_tendik' => 2,
                'id_level' => 3,
                'username' => 'jevan',
                'password' => Hash::make('12345'),
                'nip' => '199101022000011002',
                'no_telepon' => '081255556666',
                'email' => 'jevan@gmail.com',
                'nama' => 'Jevan',
                'avatar' => ''
            ],
            [
                'id_tendik' => 3,
                'id_level' => 3,
                'username' => 'jocelyn',
                'password' => Hash::make('12345'),
                'nip' => '199101032000012003',
                'no_telepon' => '081299998888',
                'email' => 'jocelyn@gmail.com',
                'nama' => 'Jocelyn',
                'avatar' => ''
            ],
            [
                'id_tendik' => 4,
                'id_level' => 3,
                'username' => 'aileen',
                'password' => Hash::make('12345'),
                'nip' => '199001042000012004',
                'no_telepon' => '081299998888',
                'email' => 'aileen@gmail.com',
                'nama' => 'Aileen',
                'avatar' => ''
            ],
        ];
        DB::table('m_tendik')->insert($data);
    }
}
