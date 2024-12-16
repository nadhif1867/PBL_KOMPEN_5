<?php

namespace App\Http\Controllers;
use App\Models\AlphaModel;
use App\Models\PeriodeAkademikModel;

use Illuminate\Http\Request;

class dWelcomeController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Dashboard',
            'list' => ['Home', 'Dashboard']
        ];

        $activeMenu = 'dashboard';

        $periods = PeriodeAkademikModel::all();

        $grafik = [];

        foreach ($periods as $period) {
            $mahasiswaAlpha = AlphaModel::where('id_periode', $period->id_periode)
                ->where('jumlah_alpha', '>', 0)
                ->count();

            $mahasiswaKompenSelesai = AlphaModel::where('id_periode', $period->id_periode)
                ->whereNotNull('kompen_dibayar')
                ->where('kompen_dibayar', '>', 0)
                ->count();

            $grafik[] = [
                'periode' => $period->semester . ' ' . $period->tahun_ajaran,
                'jumlah_alpha' => $mahasiswaAlpha,
                'jumlah_kompen_selesai' => $mahasiswaKompenSelesai,
            ];
        }

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

        return view('d_welcome', [
            'breadcrumb' => $breadcrumb,
            'activeMenu' => $activeMenu,
            'data' => $data,
            'grafik' => $grafik
        ]);
    }
}


