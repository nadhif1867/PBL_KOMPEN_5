<?php

namespace App\Http\Controllers;
use App\Models\AlphaModel;
use App\Models\PeriodeAkademikModel;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        $grafik = [];

        foreach ($periods as $period) {
            $mahasiswaAlpha = AlphaModel::where('id_periode', $period->id_periode) // Gunakan id_periode
                ->where('jumlah_alpha', '>', 0) // Mahasiswa yang memiliki alpha
                ->count();

            $mahasiswaKompenSelesai = AlphaModel::where('id_periode', $period->id_periode) // Gunakan id_periode
                ->whereNotNull('kompen_dibayar') // Kolom kompen_dibayar tidak null
                ->where('kompen_dibayar', '>', 0) // Kompen dibayar lebih besar dari 0
                ->count();

            $grafik[] = [
                'periode' => $period->semester . ' ' . $period->tahun_ajaran, // Menggabungkan semester dan tahun ajaran
                'jumlah_alpha' => $mahasiswaAlpha,
                'jumlah_kompen_selesai' => $mahasiswaKompenSelesai,
            ];
        }

        $user = Auth::guard('admin')->user();

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

