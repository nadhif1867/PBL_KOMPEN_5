<?php

namespace App\Http\Controllers;

use App\Models\AdminModel;
use App\Models\LevelModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class aAdminController extends Controller
{
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Daftar User Admin',
            'list' => ['Home', 'User Admin']
        ];

        $page = (object)[
            'title' => 'Daftar Admin',
        ];

        $aLevel = LevelModel::all();

        $activeMenu = 'aAdmin';

        return view('aAdmin.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'aLevel' => $aLevel, 'activeMenu' => $activeMenu]);
    }

    public function list(Request $request)
    {
        $aAdmins = AdminModel::select('id_admin', 'username', 'nip', 'no_telepon', 'email', 'nama', 'avatar')
            ->with('level');

        // if ($request -> nim) {
        //     $aAdmins->where('nim', $request->nim);
        // }

        return DataTables::of($aAdmins)
            ->addIndexColumn()
            ->addColumn('aksi', function ($aAdmin) {
                $btn = '<button onclick="modalAction(\'' . url('/aAdmin/' . $aAdmin->id_admin . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button>';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function show_ajax(string $id)
    {
        $aAdmin = AdminModel::find($id);

        return view('aAdmin.show_ajax', ['aAdmin' => $aAdmin]);
    }
}
