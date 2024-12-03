<?php

namespace App\Http\Controllers;

use App\Models\LevelModel;
use Illuminate\Foundation\Testing\Concerns\MakesHttpRequests;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class aLevelController extends Controller
{
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Daftar Level',
            'list' => ['Home', 'Level']
        ];

        $page = (object)[
            'title' => 'Daftar Level',
        ];

        $aLevel = LevelModel::all();

        $activeMenu = 'aLevel';

        return view('aLevel.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'aLevel' => $aLevel, 'activeMenu' => $activeMenu]);
    }

    public function list(Request $request) 
    {
        $aLevels = LevelModel::select('id_level', 'kode_level', 'nama_level');

        if ($request -> kode_level) {
            $aLevels->where('kode_level', $request->kode_level);
        }

        return DataTables::of($aLevels)
            ->addIndexColumn()
            ->addColumn('aksi', function ($aLevel) {
                $btn = '<button onclick="modalAction(\'' . url('/aLevel/' . $aLevel->id_level . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button>';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function show_ajax(string $id)
    {
        $aLevel = LevelModel::find($id);

        return view('aLevel.show_ajax', ['aLevel' => $aLevel]);
    }
}
