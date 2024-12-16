<?php

namespace App\Http\Controllers;

use App\Models\BidangKompetensiModel;
use App\Models\DosenModel;
use App\Models\JenisKompenModel;
use App\Models\TugasDosenModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class aTugasDosenController extends Controller
{
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Daftar Tugas Dosen',
            'list' => ['Home', 'Tugas Dosen']
        ];

        $page = (object)[
            'title' => 'Daftar Tugas Dosen',
        ];

        $aDosen = DosenModel::all();
        $aBidangKompetensi = BidangKompetensiModel::all();
        $aJenisKompen = JenisKompenModel::all();

        $activeMenu = 'aTugasDosen';

        return view('aTugasDosen.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'aDosen' => $aDosen, 'aBidangKompetensi' => $aBidangKompetensi, 'aJenisKompen' => $aJenisKompen, 'activeMenu' => $activeMenu]);
    }

    public function list(Request $request)
    {
        $aTugasDosens = TugasDosenModel::select('id_tugas_dosen', 'nama_tugas', 'deskripsi', 'status', 'tanggal_mulai', 'tanggal_selesai', 'jam_kompen', 'kuota', 'id_bidkom', 'id_jenis_kompen', 'id_dosen')
            ->with('dosen')
            ->with('bidangkompetensi')
            ->with('jeniskompen');

        // if ($request -> nim) {
        //     $aTugasAdmins->where('nim', $request->nim);
        // }

        return DataTables::of($aTugasDosens)
            ->addIndexColumn()
            ->addColumn('deadline', function($row){
                return $row->tanggal_mulai. '-' .$row->tanggal_selesai;
            })
            ->addColumn('aksi', function ($aTugasDosen) {
                $btn = '<button onclick="modalAction(\'' . url('/aTugasDosen/' . $aTugasDosen->id_tugas_dosen . '/show_ajax') . '\')" class="btn btn-info btn-sm" style="margin-right: 5px;">Detail</button>';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function show_ajax(string $id)
    {
        $aTugasDosen = TugasDosenModel::find($id);

        return view('aTugasDosen.show_ajax', ['aTugasDosen' => $aTugasDosen]);
    }
}
