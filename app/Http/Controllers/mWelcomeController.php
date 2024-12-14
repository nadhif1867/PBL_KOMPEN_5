<?php

namespace App\Http\Controllers;
use App\Models\AlphaModel;

use Illuminate\Http\Request;

class mWelcomeController extends Controller
{
    public function index()
    {
        // Hardcoded user ID
        $userId = 3;
        //$userId = auth()->user()->id;

        $alphaData = AlphaModel::where('id_mahasiswa', $userId)->first();

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
