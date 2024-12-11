<?php

namespace App\Http\Controllers;

use App\Models\AlphaModel;
use App\Models\MahasiswaModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Yajra\DataTables\Facades\DataTables;

class dMahasiswaAlphaController extends Controller
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

        $dMahasiswa = MahasiswaModel::all();

        $activeMenu = 'dMahasiswaAlpha';

        return view('dMahasiswaAlpha.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'dMahasiswa' => $dMahasiswa, 'activeMenu' => $activeMenu]);
    }

    public function list(Request $request)
    {
        $dMahasiswaAlphas = AlphaModel::select('id_alpha', 'id_mahasiswa', 'jumlah_alpha', 'kompen_dibayar', 'id_periode')
            ->with('mahasiswa')
            ->with('periode');

        return DataTables::of($dMahasiswaAlphas)
            ->addIndexColumn()
            ->addColumn('aksi', function ($dMahasiswaAlpha) {
                $btn = '<button onclick="modalAction(\'' . url('/dMahasiswaAlpha/' . $dMahasiswaAlpha->id_alpha . '/show_ajax') . '\')" class="btn btn-info btn-sm" style="margin-right: 10px;">Detail</button>';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }
}


