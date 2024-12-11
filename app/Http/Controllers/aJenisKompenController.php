<?php

namespace App\Http\Controllers;

use App\Models\JenisKompenModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class aJenisKompenController extends Controller
{
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Daftar Jenis Kompen',
            'list' => ['Home', 'Jenis Kompen']
        ];

        $page = (object)[
            'title' => 'Daftar Jenis Kompen',
        ];

        $aJenisKompen = JenisKompenModel::all();

        $activeMenu = 'aJenisKompen';

        return view('aJenisKompen.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'aJenisKompen' => $aJenisKompen, 'activeMenu' => $activeMenu]);
    }

    public function list(Request $request)
    {
        $aJenisKompens = JenisKompenModel::select('id_jenis_kompen', 'jenis_kompen');

        // if ($request -> nim) {
        //     $aJenisKompens->where('nim', $request->nim);
        // }

        return DataTables::of($aJenisKompens)
            ->addIndexColumn()
            ->addColumn('aksi', function ($aJenisKompen) {
                $btn = '<button onclick="modalAction(\'' . url('/aJenisKompen/' . $aJenisKompen->id_jenis_kompen . '/show_ajax') . '\')" class="btn btn-info btn-sm" style="margin-right: 5px;">Detail</button>';
                $btn .= '<button onclick="modalAction(\'' . url('/aJenisKompen/' . $aJenisKompen->id_jenis_kompen . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button>';
                $btn .= '<button onclick="modalAction(\'' . url('/aJenisKompen/' . $aJenisKompen->id_jenis_kompen . '/delete_ajax') . '\')" class="btn btn-danger btn-sm" style="margin-left: 5px;">Edit</button>';

                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function show_ajax(string $id)
    {
        $aJenisKompen = JenisKompenModel::find($id);

        return view('aJenisKompen.show_ajax', ['aJenisKompen' => $aJenisKompen]);
    }

    public function create_ajax()
    {
        $aJenisKompen = JenisKompenModel::select('id_jenis_kompen', 'jenis_kompen')->get();

        return view('aJenisKompen.create_ajax');
    }

    public function store_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'jenis_kompen' => 'required|string'
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(),
                ]);
            }

            JenisKompenModel::create($request->all());

            return response()->json([
                'status' => true,
                'message' => 'Data berhasil disimpan'
            ]);
        }
        return redirect('/aJenisKompen');
    }

    public function edit_ajax(String $id)
    {
        $aJenisKompen = JenisKompenModel::find($id);

        return view('aJenisKompen.edit_ajax', ['aJenisKompen' => $aJenisKompen]);
    }

    public function update_ajax(Request $request, $id)
    {
        // Cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
        } {
            $rules = [
                'jenis_kompen' => 'required|string|min:2',
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

            $check = JenisKompenModel::find($id);
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
        return redirect('/aJenisKompen');
    }

    public function confirm_ajax(String $id)
    {
        $aJenisKompen = JenisKompenModel::find($id);

        return view('aJenisKompen.confirm_ajax', ['aJenisKompen' => $aJenisKompen]);
    }

    public function delete_ajax(Request $request, $id)
    {
        // cek apakah requset dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $aJenisKompen = JenisKompenModel::find($id);
            if ($aJenisKompen) {
                $aJenisKompen->delete();
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
        return redirect('/aJenisKompen');
    }
}
