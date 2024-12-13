<?php

namespace App\Http\Controllers;

use App\Models\AdminModel;
use App\Models\BidangKompetensiModel;
use App\Models\JenisKompenModel;
use App\Models\TugasAdminModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class aTugasAdminController extends Controller
{
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Daftar Tugas Admin',
            'list' => ['Home', 'Tugas Admin']
        ];

        $page = (object)[
            'title' => 'Daftar Tugas Admin',
        ];

        $aAdmin = AdminModel::all();
        $aBidangKompetensi = BidangKompetensiModel::all();
        $aJenisKompen = JenisKompenModel::all();

        $activeMenu = 'aTugasAdmin';

        return view('aTugasAdmin.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'aAdmin' => $aAdmin, 'aBidangKompetensi' => $aBidangKompetensi, 'aJenisKompen' => $aJenisKompen, 'activeMenu' => $activeMenu]);
    }

    public function list(Request $request)
    {
        $aTugasAdmins = TugasAdminModel::select('id_tugas_admin', 'nama_tugas', 'deskripsi', 'status', 'tanggal_mulai', 'tanggal_selesai', 'jam_kompen', 'kuota', 'id_bidkom', 'id_jenis_kompen', 'id_admin')
            ->with('admin')
            ->with('bidangkompetensi')
            ->with('jeniskompen');

        return DataTables::of($aTugasAdmins)
            ->addIndexColumn()
            ->make(true);
    }

    public function show_ajax(string $id)
    {
        $aTugasAdmin = TugasAdminModel::find($id);

        return view('aTugasAdmin.show_ajax', ['aTugasAdmin' => $aTugasAdmin]);
    }
}
