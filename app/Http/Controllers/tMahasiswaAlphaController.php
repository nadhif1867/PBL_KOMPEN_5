<?php

namespace App\Http\Controllers;

use App\Models\AlphaModel;
use App\Models\MahasiswaModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class tMahasiswaAlphaController extends Controller
{
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Daftar Mahasiswa Alpha',
            'list' => ['Home', 'Mahasiswa Alpha']
        ];

        $page = (object)[
            'title' => 'Daftar Mahasiswa Alpha',
        ];

        $tMahasiswa = MahasiswaModel::all();

        $activeMenu = 'tMahasiswaAlpha';

        return view('tMahasiswaAlpha.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'tMahasiswa' => $tMahasiswa, 'activeMenu' => $activeMenu]);
    }

    public function list(Request $request)
    {
        $dMahasiswaAlphas = AlphaModel::select('id_alpha', 'id_mahasiswa', 'jumlah_alpha', 'kompen_dibayar', 'id_periode')
            ->with('mahasiswa')
            ->with('periode');

        return DataTables::of($dMahasiswaAlphas)
            ->addIndexColumn()
            ->addColumn('aksi', function ($tMahasiswaAlpha) {
                $btn = '<button onclick="modalAction(\'' . url('/tMahasiswaAlpha/' . $tMahasiswaAlpha->id_alpha . '/show_ajax') . '\')" class="btn btn-info btn-sm" style="margin-right: 10px;">Detail</button>';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }
}
