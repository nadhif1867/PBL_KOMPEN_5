<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ManageKompenSeeder extends Seeder
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
                'id_tugas_kompen' => 1,
                'id_mahasiswa' => 1,
                'id_tugas_admin' => 1,
                'status_penerimaan' => 'request',
                'tanggal_apply' => $dateNow
            ],
        ];
        DB::table('m_tugas_kompen')->insert($data);
    }
}
