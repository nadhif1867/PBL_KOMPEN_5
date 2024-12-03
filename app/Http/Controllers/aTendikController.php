<?php

namespace App\Http\Controllers;

use App\Models\LevelModel;
use App\Models\TendikModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class aTendikController extends Controller
{
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Daftar User Tendik',
            'list' => ['Home', 'User Tendik']
        ];

        $page = (object)[
            'title' => 'Daftar Tendik',
        ];

        $aLevel = LevelModel::all();

        $activeMenu = 'aTendik';

        return view('aTendik.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'aLevel' => $aLevel, 'activeMenu' => $activeMenu]);
    }

    public function list(Request $request)
    {
        $aTendiks = TendikModel::select('id_tendik', 'username', 'nip', 'no_telepon', 'email', 'nama', 'avatar')
            ->with('level');

        // if ($request -> nim) {
        //     $aTendiks->where('nim', $request->nim);
        // }

        return DataTables::of($aTendiks)
            ->addIndexColumn()
            ->addColumn('aksi', function ($aTendik) {
                $btn = '<button onclick="modalAction(\'' . url('/aTendik/' . $aTendik->id_tendik . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button>';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function show_ajax(string $id)
    {
        $aTendik = TendikModel::find($id);

        return view('aTendik.show_ajax', ['aTendik' => $aTendik]);
    }
}
