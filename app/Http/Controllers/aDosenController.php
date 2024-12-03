<?php

namespace App\Http\Controllers;

use App\Models\DosenModel;
use App\Models\LevelModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class aDosenController extends Controller
{
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Daftar User Dosen',
            'list' => ['Home', 'User Dosen']
        ];

        $page = (object)[
            'title' => 'Daftar Dosen',
        ];

        $aLevel = LevelModel::all();

        $activeMenu = 'aDosen';

        return view('aDosen.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'aLevel' => $aLevel, 'activeMenu' => $activeMenu]);
    }

    public function list(Request $request)
    {
        $aDosens = DosenModel::select('id_dosen', 'username', 'nip', 'no_telepon', 'email', 'nama', 'avatar')
            ->with('level');

        // if ($request -> nim) {
        //     $aDosens->where('nim', $request->nim);
        // }

        return DataTables::of($aDosens)
            ->addIndexColumn()
            ->addColumn('aksi', function ($aDosen) {
                $btn = '<button onclick="modalAction(\'' . url('/aDosen/' . $aDosen->id_dosen . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button>';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function show_ajax(string $id)
    {
        $aDosen = DosenModel::find($id);

        return view('aDosen.show_ajax', ['aDosen' => $aDosen]);
    }
}
