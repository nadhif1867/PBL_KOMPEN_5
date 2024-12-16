<?php

namespace App\Http\Controllers;

use App\Models\BidangKompetensiModel;
use App\Models\DosenModel;
use App\Models\JenisKompenModel;
use App\Models\PeriodeAkademikModel;
use App\Models\TugasDosenModel;
use App\Models\TugasKompenModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class dManageKompenController extends Controller
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

        $activeMenu = 'dManageKompen';
        // Return view untuk halaman manajemen Tugas Kompen
        return view('dManageKompen.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }

    public function list(Request $request)
    {
        $dManageKompens = TugasDosenModel::select('id_tugas_dosen', 'nama_tugas', 'deskripsi', 'status', 'tanggal_mulai', 'tanggal_selesai', 'jam_kompen', 'kuota', 'id_bidkom', 'id_jenis_kompen', 'id_dosen')
            ->with('dosen')
            ->with('jeniskompen')
            ->with('bidangkompetensi');

        return DataTables::of($dManageKompens)
            ->addIndexColumn()
            ->addColumn('deadline', function($row){
                return $row->tanggal_mulai. '  -  ' .$row->tanggal_selesai;
            })
            ->addColumn('aksi', function ($dManageKompen) {
                $btn = '<button onclick="modalAction(\'' . url('/dManageKompen/' . $dManageKompen->id_tugas_dosen . '/show_ajax') . '\')" class="btn btn-info btn-sm" style="margin-right: 5px;">Detail</button>';
                $btn .= '<button onclick="modalAction(\'' . url('/dManageKompen/' . $dManageKompen->id_tugas_dosen . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/dManageKompen/' . $dManageKompen->id_tugas_dosen . '/delete_ajax') . '\')"  class="btn btn-danger btn-sm" style="margin-left: 5px;">Hapus</button> ';
                // $btn .= '<button onclick="modalAction(\'' . url('/dManageKompen/' . $dManageKompen->id_tugas_dosen . '/apply') . '\')"  class="btn btn-success btn-sm" style="margin-top: 5px;">Dikerjakan Oleh</button> ';
                // $btn .= '<button onclick="modalAction(\'' . url('/dManageKompen/' . $dManageKompen->id_tugas_dosen . '/close') . '\')"  class="btn btn-warning btn-sm" style="margin-top: 1px;">Tugas Ditutup</button> ';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function create_ajax()
    {
        $aDosen = DosenModel::select('id_dosen', 'nama')->get();
        $aJenisKompen = JenisKompenModel::select('id_jenis_kompen', 'jenis_kompen')->get();
        $aBidangKompetensi = BidangKompetensiModel::select('id_bidkom', 'tag_bidkom')->get();
        $aPeriodeAkademik = PeriodeAkademikModel::select('id_periode', 'tahun_ajaran')->get();


        return view('dManageKompen.create_ajax')
            ->with('aDosen', $aDosen)
            ->with('aJenisKompen', $aJenisKompen)
            ->with('aBidangKompetensi', $aBidangKompetensi)
            ->with('aPeriodeAkademik', $aPeriodeAkademik);
    }

    public function store_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'id_dosen' => 'required|integer',
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

            TugasDosenModel::create($request->all());

            return response()->json([
                'status' => true,
                'message' => 'Data berhasil disimpan',
            ]);
        }
        return redirect('/dManageKompen');
    }

    public function edit_ajax(String $id)
    {
        $aTugasDosen = TugasDosenModel::find($id);

        return view('dManageKompen.edit_ajax', ['aTugasDosen' => $aTugasDosen]);
    }

    public function update_ajax(Request $request, $id)
    {
        // Cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
        } {
            $rules = [
                // 'id_dosen' => 'required|integer',
                'nama_tugas' => 'required|string',
                'deskripsi' => 'required|string',
                'status' => 'required',
                'tanggal_mulai' => 'required',
                'tanggal_selesai' => 'required',
                'jam_kompen' => 'required|string',
                'kuota' => 'required|integer',
                // 'id_bidkom' => 'required|interger',
                // 'id_jenis_kompen' => 'required|integer',
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

            $check = TugasDosenModel::find($id);
            if ($check) {
                $check->update($request->all());
                return response()->json([
                    'status' => true,
                    'message' => 'Data user berhasil diupdate'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }
        return redirect('/dManageKompen');
    }

    public function confirm_ajax(String $id)
    {
        $aTugasDosen = TugasDosenModel::find($id);

        return view('dManageKompen.confirm_ajax', ['aTugasDosen' => $aTugasDosen]);
    }

    public function delete_ajax(Request $request, $id)
    {
        // cek apakah requset dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $aTugasDosen = TugasDosenModel::find($id);
            if ($aTugasDosen) {
                $aTugasDosen->delete();
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
        return redirect('/dManageKompen');
    }
}
