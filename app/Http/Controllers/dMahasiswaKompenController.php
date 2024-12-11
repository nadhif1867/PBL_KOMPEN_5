<?php

namespace App\Http\Controllers;

use App\Models\AlphaModel;
use App\Models\MahasiswaModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class dMahasiswaKompenController extends Controller
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

        $dMahasiswa = MahasiswaModel::all();

        $activeMenu = 'dMahasiswaKompen';

        return view('dMahasiswaKompen.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'dMahasiswa' => $dMahasiswa, 'activeMenu' => $activeMenu]);
    }

    public function list(Request $request)
    {
        $dMahasiswaAlphas = AlphaModel::select('id_alpha', 'id_mahasiswa', 'jumlah_alpha', 'kompen_dibayar', 'id_periode')
            ->with('mahasiswa')
            ->with('periode');

        return DataTables::of($dMahasiswaAlphas)
            ->addIndexColumn()
            ->addColumn('aksi', function ($dMahasiswaKompen) {
                $btn = '<button onclick="modalAction(\'' . url('/dMahasiswaKompen/' . $dMahasiswaKompen->id_alpha . '/show_ajax') . '\')" class="btn btn-info btn-sm" style="margin-right: 10px;">Detail</button>';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function show_ajax(string $id)
    {
        $dMahasiswaKompen = AlphaModel::find($id);

        return view('dMahasiswaKompen.show_ajax', ['dMahasiswaKompen' => $dMahasiswaKompen]);
    }
}
