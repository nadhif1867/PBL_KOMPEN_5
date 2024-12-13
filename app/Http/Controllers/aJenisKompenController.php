<?php

namespace App\Http\Controllers;

use App\Models\JenisKompenModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class aJenisKompenController extends Controller
{
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Daftar Jenis Kompen',
            'list' => ['Home', 'Jenis Kompen']
        ];

        $page = (object)[
            'title' => 'Daftar Jenis Kompen',
        ];

        $aJenisKompen = JenisKompenModel::all();

        $activeMenu = 'aJenisKompen';

        return view('aJenisKompen.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'aJenisKompen' => $aJenisKompen, 'activeMenu' => $activeMenu]);
    }

    public function list(Request $request)
    {
        $aJenisKompens = JenisKompenModel::select('id_jenis_kompen', 'jenis_kompen');

        // if ($request -> nim) {
        //     $aJenisKompens->where('nim', $request->nim);
        // }

        return DataTables::of($aJenisKompens)
            ->addIndexColumn()
            ->addColumn('aksi', function ($aJenisKompen) {
                $btn = '<button onclick="modalAction(\'' . url('/aJenisKompen/' . $aJenisKompen->id_jenis_kompen . '/show_ajax') . '\')" class="btn btn-info btn-sm" style="margin-right: 5px;">Detail</button>';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function show_ajax(string $id)
    {
        $aJenisKompen = JenisKompenModel::find($id);

        return view('aJenisKompen.show_ajax', ['aJenisKompen' => $aJenisKompen]);
    }
}
