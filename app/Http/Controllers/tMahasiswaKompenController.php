<?php

namespace App\Http\Controllers;

use App\Models\AlphaModel;
use App\Models\MahasiswaModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class tMahasiswaKompenController extends Controller
{
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Daftar Mahasiswa Kompen',
            'list' => ['Home', 'Mahasiswa Kompen']
        ];

        $page = (object)[
            'title' => 'Daftar Mahasiswa Kompen',
        ];

        $tMahasiswa = MahasiswaModel::all();

        $activeMenu = 'tMahasiswaKompen';

        return view('tMahasiswaKompen.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'tMahasiswa' => $tMahasiswa, 'activeMenu' => $activeMenu]);
    }

    public function list(Request $request)
    {
        $dMahasiswaAlphas = AlphaModel::select('id_alpha', 'id_mahasiswa', 'jumlah_alpha', 'kompen_dibayar', 'id_periode')
            ->with('mahasiswa')
            ->with('periode');

        return DataTables::of($dMahasiswaAlphas)
            ->addIndexColumn()
            ->addColumn('aksi', function ($tMahasiswaKompen) {
                $btn = '<button onclick="modalAction(\'' . url('/tMahasiswaKompen/' . $tMahasiswaKompen->id_alpha . '/show_ajax') . '\')" class="btn btn-info btn-sm" style="margin-right: 10px;">Detail</button>';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function show_ajax(string $id)
    {
        $tMahasiswaKompen = AlphaModel::find($id);

        return view('tMahasiswaKompen.show_ajax', ['tMahasiswaKompen' => $tMahasiswaKompen]);
    }
}
