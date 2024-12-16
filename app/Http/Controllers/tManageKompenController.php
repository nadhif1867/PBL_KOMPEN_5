<?php

namespace App\Http\Controllers;

use App\Models\BidangKompetensiModel;
use App\Models\JenisKompenModel;
use App\Models\TendikModel;
use App\Models\TugasTendikModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class tManageKompenController extends Controller
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

        $activeMenu = 'tManageKompen';
        // Return view untuk halaman manajemen Tugas Kompen
        return view('tManageKompen.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }

    public function list(Request $request)
    {
        $tManageKompens = TugasTendikModel::select('id_tugas_tendik', 'nama_tugas', 'deskripsi', 'status', 'tanggal_mulai', 'tanggal_selesai', 'jam_kompen', 'kuota', 'id_bidkom', 'id_jenis_kompen', 'id_tendik')
            ->with('tendik')
            ->with('jeniskompen')
            ->with('bidangkompetensi');

        return DataTables::of($tManageKompens)
            ->addIndexColumn()
            ->addColumn('deadline', function($row){
                return $row->tanggal_mulai. '  -  ' .$row->tanggal_selesai;
            })
            ->addColumn('aksi', function ($tManageKompen) {
                $btn = '<button onclick="modalAction(\'' . url('/tManageKompen/' . $tManageKompen->id_tugas_tendik . '/show_ajax') . '\')" class="btn btn-info btn-sm" style="margin-right: 5px;">Detail</button>';
                $btn .= '<button onclick="modalAction(\'' . url('/tManageKompen/' . $tManageKompen->id_tugas_tendik . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/tManageKompen/' . $tManageKompen->id_tugas_tendik . '/delete_ajax') . '\')"  class="btn btn-danger btn-sm" style="margin-left: 5px;">Hapus</button> ';
                // $btn .= '<button onclick="modalAction(\'' . url('/tManageKompen/' . $tManageKompen->id_tugas_tendik . '/apply') . '\')"  class="btn btn-success btn-sm" style="margin-top: 5px;">Dikerjakan Oleh</button> ';
                // $btn .= '<button onclick="modalAction(\'' . url('/tManageKompen/' . $tManageKompen->id_tugas_tendik . '/close') . '\')"  class="btn btn-warning btn-sm" style="margin-top: 1px;">Tugas Ditutup</button> ';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function create_ajax()
    {
        $aTendik = TendikModel::select('id_tendik', 'nama')->get();
        $aJenisKompen = JenisKompenModel::select('id_jenis_kompen', 'jenis_kompen')->get();
        $aBidangKompetensi = BidangKompetensiModel::select('id_bidkom', 'tag_bidkom')->get();
        $aPeriodeAkademik = PeriodeAkademikModel::select('id_periode', 'tahun_ajaran')->get();


        return view('tManageKompen.create_ajax')
            ->with('aTendik', $aTendik)
            ->with('aJenisKompen', $aJenisKompen)
            ->with('aBidangKompetensi', $aBidangKompetensi)
            ->with('aPeriodeAkademik', $aPeriodeAkademik);
    }

    public function store_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'id_tendik' => 'required|integer',
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

            TugasTendikModel::create($request->all());

            return response()->json([
                'status' => true,
                'message' => 'Data berhasil disimpan',
            ]);
        }
        return redirect('/tManageKompen');
    }

    public function edit_ajax(String $id)
    {
        $tTugasTendik = TugasTendikModel::find($id);

        return view('tManageKompen.edit_ajax', ['tTugasTendik' => $tTugasTendik]);
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

            $check = TugasTendikModel::find($id);
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
        return redirect('/tManageKompen');
    }

    public function confirm_ajax(String $id)
    {
        $aTugasTendik = TugasTendikModel::find($id);

        return view('tManageKompen.confirm_ajax', ['aTugasTendik' => $aTugasTendik]);
    }

    public function delete_ajax(Request $request, $id)
    {
        // cek apakah requset dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $aTugasTendik = TugasTendikModel::find($id);
            if ($aTugasTendik) {
                $aTugasTendik->delete();
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
        return redirect('/tManageKompen');
    }
}
