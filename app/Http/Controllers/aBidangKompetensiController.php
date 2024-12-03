<?php

namespace App\Http\Controllers;

use App\Models\BidangKompetensiModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class aBidangKompetensiController extends Controller
{
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Manage Bidang Kompetensi',
            'list' => ['Home', 'Manage Bidang Kompetensi']
        ];

        $page = (object)[
            'title' => 'Manage Bidang Kompetensi',
        ];

        $aBidangKompetensi = BidangKompetensiModel::all();

        $activeMenu = 'aBidangKompetensi';

        return view('aBidangKompetensi.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'aBidangKompetensi' => $aBidangKompetensi, 'activeMenu' => $activeMenu]);
    }

    public function list(Request $request)
    {
        $aBidangKompetensis = BidangKompetensiModel::select('id_bidkom', 'nama_bidkom', 'tag_bidkom');
    

        // if ($request -> nim) {
        //     $aDosens->where('nim', $request->nim);
        // }

        return DataTables::of($aBidangKompetensis)
            ->addIndexColumn()
            ->addColumn('aksi', function ($aBidangKompetensi) {
                $btn = '<button onclick="modalAction(\'' . url('/aBidangKompetensi/' . $aBidangKompetensi->id_bidkom . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button>';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function show_ajax(string $id)
    {
        $aBidangKompetensi = BidangKompetensiModel::find($id);

        return view('aBidangKompetensi.show_ajax', ['aBidangKompetensi' => $aBidangKompetensi]);
    }
}
