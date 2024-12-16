<?php

namespace App\Http\Controllers;

use App\Models\AdminModel;
use App\Models\BidangKompetensiModel;
use App\Models\JenisKompenModel;
use App\Models\PeriodeAkademikModel;
use App\Models\TugasAdminModel;
use App\Models\TugasKompenModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class aManageKompenController extends Controller
{
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Manage Data Kompen',
            'list' => ['Home', 'Manage Kompen']
        ];

        $page = (object)[
            'title' => 'Manage Data Kompen',
        ];

        $activeMenu = 'aManageKompen';
        // Return view untuk halaman manajemen Tugas Kompen
        return view('aManageKompen.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }

    public function list(Request $request)
    {
        $aManageKompens = TugasAdminModel::select('id_tugas_admin', 'nama_tugas', 'deskripsi', 'status', 'tanggal_mulai', 'tanggal_selesai', 'jam_kompen', 'kuota', 'id_bidkom', 'id_jenis_kompen', 'id_admin')
            ->with('admin')
            ->with('jeniskompen')
            ->with('bidangkompetensi');

        return DataTables::of($aManageKompens)
            ->addIndexColumn()
            ->addColumn('deadline', function($row){
                return $row->tanggal_mulai. '  -  ' .$row->tanggal_selesai;
            })
            ->addColumn('aksi', function ($aManageKompen) {
                $btn = '<button onclick="modalAction(\'' . url('/aManageKompen/' . $aManageKompen->id_tugas_admin . '/show_ajax') . '\')" class="btn btn-info btn-sm" style="margin-right: 5px;">Detail</button>';
                $btn .= '<button onclick="modalAction(\'' . url('/aManageKompen/' . $aManageKompen->id_tugas_admin . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/aManageKompen/' . $aManageKompen->id_tugas_admin . '/delete_ajax') . '\')"  class="btn btn-danger btn-sm" style="margin-left: 5px;">Hapus</button> ';
                // $btn .= '<button onclick="modalAction(\'' . url('/aManageKompen/' . $aManageKompen->id_tugas_admin . '/apply') . '\')"  class="btn btn-success btn-sm" style="margin-top: 5px;">Dikerjakan Oleh</button> ';
                // $btn .= '<button onclick="modalAction(\'' . url('/aManageKompen/' . $aManageKompen->id_tugas_admin . '/close') . '\')"  class="btn btn-warning btn-sm" style="margin-top: 1px;">Tugas Ditutup</button> ';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function show_ajax(string $id)
    {
        $aTugasAdmin = TugasAdminModel::find($id);

        return view('aManageKompen.show_ajax', ['aTugasAdmin' => $aTugasAdmin]);
    }

    public function create_ajax()
    {
        $aAdmin = AdminModel::select('id_admin', 'nama')->get();
        $aJenisKompen = JenisKompenModel::select('id_jenis_kompen', 'jenis_kompen')->get();
        $aBidangKompetensi = BidangKompetensiModel::select('id_bidkom', 'tag_bidkom')->get();
        $aPeriodeAkademik = PeriodeAkademikModel::select('id_periode', 'tahun_ajaran')->get();

        return view('aManageKompen.create_ajax')
            ->with('aAdmin', $aAdmin)
            ->with('aJenisKompen', $aJenisKompen)
            ->with('aBidangKompetensi', $aBidangKompetensi)
            ->with('aPeriodeAkademik', $aPeriodeAkademik);
    }

    public function store_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [ 
                'id_admin' => 'required|integer',
                'nama_tugas' => 'required|string',
                'deskripsi' => 'required|string',
                'status' => 'required',
                'tanggal_mulai' => 'required|date',
                'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
                'jam_kompen' => 'required|string',
                'kuota' => 'required|integer',
                'id_bidkom' => 'required|integer',
                'id_jenis_kompen' => 'required|integer',
                'id_periode' => 'required|integer',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(),
                ]);
            }

            // $tugasAdmin = 
            TugasAdminModel::create($request->all());

            // tugasKompenModel::create([
            //     'id_tugas_kompen' => $tugasAdmin->id_tugas_admin, // atau key unik lain
            //     'id_mahasiswa' => null, // Null jika belum ada mahasiswa terkait
            //     'id_tugas_admin' => $tugasAdmin->id_tugas_admin,
            //     'status_penerimaan' => 'request', // Status awal
            //     'tanggal_apply' => now(),
            // ]);

            return response()->json([
                'status' => true,
                'message' => 'Data berhasil disimpan',
            ]);
        }
        return redirect('/aManageKompen');
    }

    public function edit_ajax(String $id)
    {
        $aTugasAdmin = TugasAdminModel::find($id);

        return view('aManageKompen.edit_ajax', ['aTugasAdmin' => $aTugasAdmin]);
    }

    public function update_ajax(Request $request, $id)
    {
        // Cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
        } {
            $rules = [
                'nama_tugas' => 'required|string',
                'deskripsi' => 'required|string',
                'status' => 'required',
                'tanggal_mulai' => 'required',
                'tanggal_selesai' => 'required',
                'jam_kompen' => 'required|string',
                'kuota' => 'required|integer',
            ];

            // use Illuminate\Support\Facades\vaidator
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false, // response status, false: error/gagal, true: berhasil
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(),
                ]);
            }

            $check = TugasAdminModel::find($id);
            if ($check) {
                $check->update($request->all());
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil diupdate'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }
        return redirect('/aManageKompen');
    }

    public function confirm_ajax(String $id)
    {
        $aTugasAdmin = TugasAdminModel::find($id);
        $aAdmin = AdminModel::select('id_admin', 'nama')->get();
        $aJenisKompen = JenisKompenModel::select('id_jenis_kompen', 'jenis_kompen')->get();
        $aBidangKompetensi = BidangKompetensiModel::select('id_bidkom', 'tag_bidkom')->get();

        return view('aManageKompen.confirm_ajax', ['aTugasAdmin' => $aTugasAdmin])
            ->with('admin')
            ->with('jeniskompen')
            ->with('bidangkompetensi', $aBidangKompetensi);;
    }

    public function delete_ajax(Request $request, $id)
    {
        // cek apakah requset dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $aTugasAdmin = TugasAdminModel::find($id);
            if ($aTugasAdmin) {
                $aTugasAdmin->delete();
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil dihapus'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }
        return redirect('/aManageKompen');
    }
}
