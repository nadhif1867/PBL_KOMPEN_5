<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BidangKompetensiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id_bidkom' => 1,
                'nama_bidkom' => 'Pemrograman Web',
                'tag_bidkom' => 'HTML'
            ],
            [
                'id_bidkom' => 2,
                'nama_bidkom' => 'Pemrograman Web',
                'tag_bidkom' => 'CSS'
            ],      
            [
                'id_bidkom' => 3,
                'nama_bidkom' => 'Pemrograman Web',
                'tag_bidkom' => 'JavaScript'
            ],  
            [
                'id_bidkom' => 4,
                'nama_bidkom' => 'Pemrograman Web',
                'tag_bidkom' => 'Frontend'
            ],  
            [
                'id_bidkom' => 5,
                'nama_bidkom' => 'Pemrograman Web',
                'tag_bidkom' => 'Backend'
            ],
            [
                'id_bidkom' => 6,
                'nama_bidkom' => 'Jaringan Komputer',
                'tag_bidkom' => 'Networking'
            ],
            [
                'id_bidkom' => 7,
                'nama_bidkom' => 'Jaringan Komputer',
                'tag_bidkom' => 'LAN'
            ],      
            [
                'id_bidkom' => 8,
                'nama_bidkom' => 'Jaringan Komputer',
                'tag_bidkom' => 'WAN'
            ],  
            [
                'id_bidkom' => 9,
                'nama_bidkom' => 'Jaringan Komputer',
                'tag_bidkom' => 'Protocols'
            ],  
            [
                'id_bidkom' => 10,
                'nama_bidkom' => 'Jaringan Komputer',
                'tag_bidkom' => 'Security'
            ],  
            [
                'id_bidkom' => 11,
                'nama_bidkom' => 'Kecerdasan Buatan',
                'tag_bidkom' => 'Artificial Intelligents'
            ],      
            [
                'id_bidkom' => 12,
                'nama_bidkom' => 'Kecerdasan Buatan',
                'tag_bidkom' => 'Machine Learning'
            ],  
            [
                'id_bidkom' => 13,
                'nama_bidkom' => 'Kecerdasan Buatan',
                'tag_bidkom' => 'Deep Learning'
            ],  
            [
                'id_bidkom' => 14,
                'nama_bidkom' => 'Kecerdasan Buatan',
                'tag_bidkom' => 'Natural Language Processing'
            ],  
            [
                'id_bidkom' => 15,
                'nama_bidkom' => 'Pengolahan Data',
                'tag_bidkom' => 'SQL'
            ],      
            [
                'id_bidkom' => 16,
                'nama_bidkom' => 'Pengolahan Data',
                'tag_bidkom' => 'Data Analysis'
            ],  
            [
                'id_bidkom' => 17,
                'nama_bidkom' => 'Pengolahan Data',
                'tag_bidkom' => 'ETL'
            ],  
            [
                'id_bidkom' => 18,
                'nama_bidkom' => 'Pengolahan Data',
                'tag_bidkom' => 'data Visualization'
            ], 
        ];
        DB::table('m_bidang_kompetensi')->insert($data);
    }
}
