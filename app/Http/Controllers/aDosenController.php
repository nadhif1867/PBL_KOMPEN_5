<?php

namespace App\Http\Controllers;

use App\Models\DosenModel;
use App\Models\LevelModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class aDosenController extends Controller
{
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Daftar User Dosen',
            'list' => ['Home', 'User Dosen']
        ];

        $page = (object)[
            'title' => 'Daftar Dosen',
        ];

        $aLevel = LevelModel::all();

        $activeMenu = 'aDosen';

        return view('aDosen.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'aLevel' => $aLevel, 'activeMenu' => $activeMenu]);
    }

    public function list(Request $request)
    {
        $aDosens = DosenModel::select('id_dosen', 'username', 'nip', 'no_telepon', 'email', 'nama', 'avatar')
            ->with('level');

        // if ($request -> nim) {
        //     $aDosens->where('nim', $request->nim);
        // }

        return DataTables::of($aDosens)
            ->addIndexColumn()
            ->addColumn('aksi', function ($aDosen) {
                $btn = '<button onclick="modalAction(\'' . url('/aDosen/' . $aDosen->id_dosen . '/show_ajax') . '\')" class="btn btn-info btn-sm" style="margin-right: 5px;">Detail</button>';
                $btn .= '<button onclick="modalAction(\'' . url('/aDosen/' . $aDosen->id_dosen . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/aDosen/' . $aDosen->id_dosen . '/delete_ajax') . '\')"  class="btn btn-danger btn-sm" style="margin-left: 5px;">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function show_ajax(string $id)
    {
        $aDosen = DosenModel::find($id);

        return view('aDosen.show_ajax', ['aDosen' => $aDosen]);
    }

    public function create_ajax()
    {
        $aLevel = LevelModel::select('id_level', 'nama_level')->get();

        return view('aDosen.create_ajax')
            ->with('level', $aLevel);
    }

    public function store_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'id_level' => 'required|integer',
                'username' => 'required|string|max:30|unique:m_dosen,username',
                'password' => 'nullable|min:5',
                'nip' => 'required|string|min:3|unique:m_dosen,nip',
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

            DosenModel::create($data);

            return response()->json([
                'status' => true,
                'message' => 'Data berhasil disimpan'
            ]);
        }
        return redirect('/aDosen');
    }

    public function edit_ajax(String $id)
    {
        $aDosen = DosenModel::find($id);

        return view('aDosen.edit_ajax', ['aDosen' => $aDosen]);
    }

    public function update_ajax(Request $request, $id)
    {
        // Cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
        } {
            $rules = [
                'id_level' => 'required|integer',
                'username' => 'required|string|max:30|unique:m_dosen,username,' . $id . ',id_dosen',
                'password' => 'nullable|min:5',
                'nip' => 'required|string|min:3|unique:m_dosen,nip,' . $id . ',id_dosen',
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

            $check = DosenModel::find($id);
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
        return redirect('/aDosen');
    }

    public function confirm_ajax(String $id)
    {
        $aDosen = DosenModel::find($id);

        return view('aDosen.confirm_ajax', ['aDosen' => $aDosen]);
    }

    public function delete_ajax(Request $request, $id)
    {
        // cek apakah requset dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $aDosen = DosenModel::find($id);
            if ($aDosen) {
                $aDosen->delete();
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
