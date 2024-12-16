<?php

namespace App\Http\Controllers;

use App\Models\BidangKompetensiModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
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
                $btn = '<button onclick="modalAction(\'' . url('/aBidangKompetensi/' . $aBidangKompetensi->id_bidkom . '/show_ajax') . '\')" class="btn btn-info btn-sm" style="margin-right: 5px;">Detail</button>';
                $btn .= '<button onclick="modalAction(\'' . url('/aBidangKompetensi/' . $aBidangKompetensi->id_bidkom . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/aBidangKompetensi/' . $aBidangKompetensi->id_bidkom . '/delete_ajax') . '\')"  class="btn btn-danger btn-sm" style="margin-left: 5px;">Hapus</button> ';
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

    // public function create_ajax()
    // {
    //     $aBidangKompetensi = BidangKompetensiModel::select('nama_bidkom', 'tag_bidkom')->get();

    //     return view('aBidangKompetensi.create_ajax');
    // }

    // public function store_ajax(Request $request)
    // {

    //     if ($request->ajax() || $request->wantsJson()) {
    //         $rules = [
    //             'nama_bidkom' => 'required|string|min:2',
    //             'tag_bidkom' => 'required|string|min:2',
    //         ];

    //         $validator = Validator::make($request->all(), $rules);

    //         if ($validator->fails()) {
    //             return response()->json([
    //                 'status' => false,
    //                 'message' => 'Validasi Gagal',
    //                 'msgField' => $validator->errors(),
    //             ]);
    //         }

    //         BidangKompetensiModel::create($request->all());

    //         return response()->json([
    //             'status' => true,
    //             'message' => 'Data bidang kompetensi berhasil disimpan'
    //         ]);
    //     }
    //     return redirect('/aBidangKompetensi');
    // }

    public function create_ajax()
    {
        return view('aBidangKompetensi.create_ajax');
    }

    public function store_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'nama_bidkom' => 'required|string|min:2',
                'tag_bidkom' => 'required|string|min:2'
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(),
                ]);
            }

            BidangKompetensiModel::create($request->all());

            return response()->json([
                'status' => true,
                'message' => 'Data berhasil disimpan'
            ]);
        }
        return redirect('/aBidangKompetensi');
    }

    public function edit_ajax(String $id)
    {
        $aBidangKompetensi = BidangKompetensiModel::find($id);

        return view('aBidangKompetensi.edit_ajax', ['aBidangKompetensi' => $aBidangKompetensi]);
    }

    public function update_ajax(Request $request, $id)
    {
        // Cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
        } {
            $rules = [
                'nama_bidkom' => 'required|string|min:2',
                'tag_bidkom' => 'required|string|min:2',
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

            $check = BidangKompetensiModel::find($id);
            if ($check) {
                $check->update($request->all());
                return response()->json([
                    'status'  => true,
                    'message' => 'Data berhasil diupdate'
                ]);
            } else {
                return response()->json([
                    'status'  => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }
        return redirect('/aBidangKompetensi');
    }

    public function confirm_ajax(String $id)
    {
        $aBidangKompetensi = BidangKompetensiModel::find($id);

        return view('aBidangKompetensi.confirm_ajax', ['aBidangKompetensi' => $aBidangKompetensi]);
    }

    public function delete_ajax(Request $request, $id)
    {
        // cek apakah requset dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $aBidangKompetensi = BidangKompetensiModel::find($id);
            if ($aBidangKompetensi) {
                $aBidangKompetensi->delete();
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
        return redirect('/aBidangKompetensi');
    }
}
