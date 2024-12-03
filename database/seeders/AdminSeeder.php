<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id_admin' => 1,
                'id_level' => 1,
                'username' => 'jason',
                'password' => Hash::make('12345'),
                'nip' => '200001012002021001',
                'no_telepon' => '081233334444',
                'email' => 'jason@gmail.com',
                'nama' => 'Jason Huang',
                'avatar' => ''
            ],
            [
                'id_admin' => 2,
                'id_level' => 1,
                'username' => 'justin',
                'password' => Hash::make('12345'),
                'nip' => '200201122022022012',
                'no_telepon' => '081255556666',
                'email' => 'justin@gmail.com',
                'nama' => 'Justin Patrick',
                'avatar' => ''
            ],
            [
                'id_admin' => 3,
                'id_level' => 1,
                'username' => 'angela',
                'password' => Hash::make('12345'),
                'nip' => '199801122020022017',
                'no_telepon' => '081299998888',
                'email' => 'angela@gmail.com',
                'nama' => 'angela fey',
                'avatar' => ''
            ],
            [
                'id_admin' => 4,
                'id_level' => 1,
                'username' => 'zee',
                'password' => Hash::make('12345'),
                'nip' => '200101122020022022',
                'no_telepon' => '081299998888',
                'email' => 'zee@gmail.com',
                'nama' => 'zee zee',
                'avatar' => ''
            ],
        ];
        DB::table('m_admin')->insert($data);
    }
}
