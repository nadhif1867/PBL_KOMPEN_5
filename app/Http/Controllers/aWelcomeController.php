<?php

namespace App\Http\Controllers;
use App\Models\AlphaModel;
use App\Models\PeriodeAkademikModel;

use Illuminate\Http\Request;



class aWelcomeController extends Controller
{
    public function index()
    {
        // Breadcrumb untuk navigasi
        $breadcrumb = (object) [
            'title' => 'Dashboard', // Judul halaman
            'list' => ['Home', 'Dashboard'] // Jalur navigasi
        ];

        // Aktifkan menu "dashboard" untuk highlight di UI
        $activeMenu = 'dashboard';

        $periods = PeriodeAkademikModel::all();

        // Grafik untuk menampilkan jumlah mahasiswa berdasarkan periode
        $grafik = [];

        foreach ($periods as $period) {
            // Hitung jumlah mahasiswa yang memiliki alpha pada periode ini
            $mahasiswaAlpha = AlphaModel::where('id_periode', $period->id_periode) // Gunakan id_periode
                ->where('jumlah_alpha', '>', 0) // Mahasiswa yang memiliki alpha
                ->count();

            // Hitung jumlah mahasiswa yang sudah kompen dibayar pada periode ini
            $mahasiswaKompenSelesai = AlphaModel::where('id_periode', $period->id_periode) // Gunakan id_periode
                ->whereNotNull('kompen_dibayar') // Kolom kompen_dibayar tidak null
                ->where('kompen_dibayar', '>', 0) // Kompen dibayar lebih besar dari 0
                ->count();

            // Masukkan data periode dan jumlah mahasiswa alpha dan kompen selesai ke dalam array
            $grafik[] = [
                'periode' => $period->semester . ' ' . $period->tahun_ajaran, // Menggabungkan semester dan tahun ajaran
                'jumlah_alpha' => $mahasiswaAlpha,
                'jumlah_kompen_selesai' => $mahasiswaKompenSelesai,
            ];
        }

        //Statistik jumlah mahasiswa kompen
        $data = [
            'totalMahasiswaAlpha' => AlphaModel::count('jumlah_alpha'),
            'mahasiswaSelesai' => AlphaModel::whereNotNull('kompen_dibayar')
                                ->where('kompen_dibayar', '>', 0)
                                ->count(),
        ];

        // // Data untuk grafik rata-rata jumlah mahasiswa kompen per periode
        // $grafik = [
        //     ['periode' => 'Genap 2022', 'jumlah' => ''],
        //     ['periode' => 'Ganjil 2023', 'jumlah' => ''],
        //     ['periode' => 'Genap 2023', 'jumlah' => ''],
        //     ['periode' => 'Ganjil 2024', 'jumlah' =>'']
        // ];

        // $grafik = PeriodeAkademikModel::withCount(['periode as jumlah' => function ($query) {
        //     $query->whereHas('periode', function ($subQuery) {
        //         $subQuery->where('jumlah_alpha', '>', 0);
        //     });
        // }])->get(['semester', 'tahun_ajaran', 'jumlah'])->map(function ($item) {
        //     return [
        //         'periode' => $item->semester . ' ' . $item->tahun_ajaran,
        //         'jumlah' => $item->jumlah
        //     ];
        // });

        // Mengirimkan data ke view a_welcome
        return view('a_welcome', [
            'breadcrumb' => $breadcrumb,
            'activeMenu' => $activeMenu,
            'data' => $data,
            'grafik' => $grafik
        ]);
    }
}

