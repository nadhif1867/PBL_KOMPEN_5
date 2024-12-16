<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        /* parent seeder */
        $this->call(LevelSeeder::class);
        $this->call(PeriodeAkademikSeeder::class);
        $this->call(JenisKompenSeeder::class);
        $this->call(BidangKompetensiSeeder::class);

        /* child 1 */
        $this->call(MahasiswaSeeder::class);
        $this->call(AdminSeeder::class);
        $this->call(DosenSeeder::class);
        $this->call(TendikSeeder::class);
        $this->call(AlphaSeeder::class);

        /* child 2 */
        $this->call(TugasAdminSeeder::class);
        $this->call(TugasDosenSeeder::class);
        $this->call(TugasTendikSeeder::class);
        $this->call(DetailBidKomSeeder::class);
    }
}
