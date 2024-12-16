<?php

namespace App\Http\Controllers;
use App\Models\AlphaModel;

use Illuminate\Http\Request;

class mWelcomeController extends Controller
{
    public function index()
    {

        // $userId = 5;
        $mahasiswa = auth('mahasiswa')->user();
        $alphaData = AlphaModel::where('id_mahasiswa', $mahasiswa->id_mahasiswa)->first();

        $breadcrumb = (object)[
            'title' => 'Overview Kompen',
            'list' => ['Home', 'Overview Kompen']
        ];

        $activeMenu = 'dashboard';

        return view('m_welcome ', [
            'breadcrumb' => $breadcrumb,
            'activeMenu' => $activeMenu,
            'jumlahAlpha' => $alphaData ? $alphaData->jumlah_alpha : 0,
            'kompenSelesai' => $alphaData ? $alphaData->kompen_dibayar : 0
        ]);
}
}
