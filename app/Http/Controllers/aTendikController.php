<?php

namespace App\Http\Controllers;

use App\Models\LevelModel;
use App\Models\TendikModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class aTendikController extends Controller
{
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Daftar User Tendik',
            'list' => ['Home', 'User Tendik']
        ];

        $page = (object)[
            'title' => 'Daftar Tendik',
        ];

        $aLevel = LevelModel::all();

        $activeMenu = 'aTendik';

        return view('aTendik.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'aLevel' => $aLevel, 'activeMenu' => $activeMenu]);
    }

    public function list(Request $request)
    {
        $aTendiks = TendikModel::select('id_tendik', 'username', 'nip', 'no_telepon', 'email', 'nama', 'avatar')
            ->with('level');

        // if ($request -> nim) {
        //     $aTendiks->where('nim', $request->nim);
        // }

        return DataTables::of($aTendiks)
            ->addIndexColumn()
            ->addColumn('aksi', function ($aTendik) {
                $btn = '<button onclick="modalAction(\'' . url('/aTendik/' . $aTendik->id_tendik . '/show_ajax') . '\')" class="btn btn-info btn-sm" style="margin-right: 5px;">Detail</button>';
                $btn .= '<button onclick="modalAction(\'' . url('/aTendik/' . $aTendik->id_tendik . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/aTendik/' . $aTendik->id_tendik . '/delete_ajax') . '\')"  class="btn btn-danger btn-sm" style="margin-left: 5px;">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function show_ajax(string $id)
    {
        $aTendik = TendikModel::find($id);

        return view('aTendik.show_ajax', ['aTendik' => $aTendik]);
    }

    public function create_ajax()
    {
        $aLevel = LevelModel::select('id_level', 'nama_level')->get();

        return view('aTendik.create_ajax')
            ->with('level', $aLevel);
    }

    public function store_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = ['id_level' => 'required|integer',
                'username' => 'required|string|max:30|unique:m_tendik,username',
                'password' => 'nullable|min:5',
                'nip' => 'required|string|min:3|unique:m_tendik,nip',
                'no_telepon' => 'required|string|',
                'email' => 'required|string|',
                'nama' => 'required|string|max:100',
                'avatar' => 'nullable'
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(),
                ]);
            }

            // Hash password sebelum disimpan
            $data = $request->all();
            $data['password'] = bcrypt($request->password);

            TendikModel::create($data);

            return response()->json([
                'status' => true,
                'message' => 'Data berhasil disimpan'
            ]);
        }
        return redirect('/aTendik');
    }

    public function edit_ajax(String $id)
    {
        $aTendik = TendikModel::find($id);

        return view('aTendik.edit_ajax', ['aTendik' => $aTendik]);
    }

    public function update_ajax(Request $request, $id)
    {
        // Cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
        } {
            $rules = [
                'id_level' => 'required|integer',
                'username' => 'required|string|max:30|unique:m_tendik,username,' . $id . ',id_tendik',
                'password' => 'nullable|min:5',
                'nip' => 'required|string|min:3|unique:m_tendik,nip,' . $id . ',id_tendik',
                'no_telepon' => 'required|string|',
                'email' => 'required|string|',
                'nama' => 'required|string|max:100',
                'avatar' => 'nullable'
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

            $check = TendikModel::find($id);
            if ($check) {
                if (!$request->filled('password')) { // jika password tidak diisi, maka hapus hapus dari request
                    $request->request->remove('password');
                }

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
        return redirect('/aTendik');
    }

    public function confirm_ajax(String $id)
    {
        $aTendik = TendikModel::find($id);

        return view('aTendik.confirm_ajax', ['aTendik' => $aTendik]);
    }

    public function delete_ajax(Request $request, $id)
    {
        // cek apakah requset dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $aTendik = TendikModel::find($id);
            if ($aTendik) {
                $aTendik->delete();
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
        return redirect('/');
    }
}
