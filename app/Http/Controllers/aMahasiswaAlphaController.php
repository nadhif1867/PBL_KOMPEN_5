<?php

namespace App\Http\Controllers;

use App\Models\AlphaModel;
use App\Models\MahasiswaModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class aMahasiswaAlphaController extends Controller
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

        $aMahasiswa = MahasiswaModel::all();

        $activeMenu = 'aMahasiswaAlpha';

        return view('aMahasiswaAlpha.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'aMahasiswa' => $aMahasiswa, 'activeMenu' => $activeMenu]);
    }

    public function list(Request $request)
    {
        $aMahasiswaAlphas = AlphaModel::select('id_alpha', 'id_mahasiswa', 'jumlah_alpha', 'id_periode')
            ->with('mahasiswa')
            ->with('periode');

        // if ($request -> nim) {
        //     $aDosens->where('nim', $request->nim);
        // }

        return DataTables::of($aMahasiswaAlphas)
            ->addIndexColumn()
            ->addColumn('aksi', function ($aMahasiswaAlpha) {
                $btn = '<button onclick="modalAction(\'' . url('/aMahasiswaAlpha/' . $aMahasiswaAlpha->id_alpha . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button>';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function show_ajax(string $id)
    {
        $aMahasiswaAlpha = AlphaModel::find($id);

        return view('aMahasiswaAlpha.show_ajax', ['aMahasiswaAlpha' => $aMahasiswaAlpha]);
    }
}
