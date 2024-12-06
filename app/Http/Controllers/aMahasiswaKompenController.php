<?php

namespace App\Http\Controllers;

use App\Models\AlphaModel;
use App\Models\MahasiswaModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class aMahasiswaKompenController extends Controller
{
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Daftar Mahasiswa Kompen',
            'list' => ['Home', 'Mahasiswa Kompen']
        ];

        $page = (object)[
            'title' => 'Daftar Mahasiswa Kompen',
        ];

        $aMahasiswa = MahasiswaModel::all();

        $activeMenu = 'aMahasiswaKompen';

        return view('aMahasiswaKompen.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'aMahasiswa' => $aMahasiswa, 'activeMenu' => $activeMenu]);
    }

    public function list(Request $request)
    {
        $aMahasiswaAlphas = AlphaModel::select('id_alpha', 'id_mahasiswa', 'jumlah_alpha', 'kompen_dibayar', 'id_periode')
            ->with('mahasiswa')
            ->with('periode');

        // if ($request -> nim) {
        //     $aDosens->where('nim', $request->nim);
        // }

        return DataTables::of($aMahasiswaAlphas)
            ->addIndexColumn()
            ->addColumn('aksi', function ($aMahasiswaKompen) {
                $btn = '<button onclick="modalAction(\'' . url('/aMahasiswaKompen/' . $aMahasiswaKompen->id_alpha . '/show_ajax') . '\')" class="btn btn-info btn-sm" style="margin-right: 10px;">Detail</button>';
                $btn .= '<button onclick="modalAction(\'' . url('/aMahasiswaKompen/' . $aMahasiswaKompen->id_alpha . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button>';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function show_ajax(string $id)
    {
        $aMahasiswaKompen = AlphaModel::find($id);

        return view('aMahasiswaKompen.show_ajax', ['aMahasiswaKompen' => $aMahasiswaKompen]);
    }

    public function edit_ajax(String $id)
    {
        $aMahasiswaKompen = AlphaModel::find($id);

        return view('aMahasiswaKompen.edit_ajax', ['aMahasiswaKompen' => $aMahasiswaKompen]);
    }

    public function update_ajax(Request $request, $id)
    {
        // Cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
        } {
            $rules = [
                'kompen_dibayar' => 'required|integer'
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

            $check = AlphaModel::find($id);
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
        return redirect('/aMahasiswaKompen');
    }
}
