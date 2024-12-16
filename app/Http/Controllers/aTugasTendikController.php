<?php

namespace App\Http\Controllers;

use App\Models\BidangKompetensiModel;
use App\Models\JenisKompenModel;
use App\Models\TendikModel;
use App\Models\TugasTendikModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class aTugasTendikController extends Controller
{
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Daftar Tugas Tendik',
            'list' => ['Home', 'Tugas Tendik']
        ];

        $page = (object)[
            'title' => 'Daftar Tugas Tendik',
        ];

        $aTendik = TendikModel::all();
        $aBidangKompetensi = BidangKompetensiModel::all();
        $aJenisKompen = JenisKompenModel::all();

        $activeMenu = 'aTugasTendik';

        return view('aTugasTendik.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'aTendik' => $aTendik, 'aBidangKompetensi' => $aBidangKompetensi, 'aJenisKompen' => $aJenisKompen, 'activeMenu' => $activeMenu]);
    }

    public function list(Request $request)
    {
        $aTugasTendiks = TugasTendikModel::select('id_tugas_tendik', 'nama_tugas', 'deskripsi', 'status', 'tanggal_mulai', 'tanggal_selesai', 'jam_kompen', 'kuota', 'id_bidkom', 'id_jenis_kompen', 'id_tendik')
            ->with('tendik')
            ->with('bidangkompetensi')
            ->with('jeniskompen');

        // if ($request -> nim) {
        //     $aTugasAdmins->where('nim', $request->nim);
        // }

        return DataTables::of($aTugasTendiks)
            ->addIndexColumn()
            ->addColumn('deadline', function($row){
                return $row->tanggal_mulai. '-' .$row->tanggal_selesai;
            })
            ->addColumn('aksi', function ($aTugasTendik) {
                $btn = '<button onclick="modalAction(\'' . url('/aTugasTendik/' . $aTugasTendik->id_tugas_tendik . '/show_ajax') . '\')" class="btn btn-info btn-sm" style="margin-right: 5px;">Detail</button>';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function show_ajax(string $id)
    {
        $aTugasTendik = TugasTendikModel::find($id);

        return view('aTugasTendik.show_ajax', ['aTugasTendik' => $aTugasTendik]);
    }
}
