<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class dManageKompenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dt = Carbon::now();
        $dateNow = $dt->toDateTimeString();
        $data = [
            [
                'id_tugas_kompen' => 2,
                'id_mahasiswa' => 2,
                'id_tugas_dosen' => 1,
                'status_penerimaan' => 'request',
                'tanggal_apply' => $dateNow
            ],
        ];
        DB::table('m_tugas_kompen')->insert($data);
    }
}
