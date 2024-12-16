<?php

namespace App\Http\Controllers;

use App\Models\AdminModel;
use App\Models\LevelModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class aAdminController extends Controller
{
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Daftar User Admin',
            'list' => ['Home', 'User Admin']
        ];

        $page = (object)[
            'title' => 'Daftar Admin',
        ];

        $aLevel = LevelModel::all();

        $activeMenu = 'aAdmin';

        return view('aAdmin.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'aLevel' => $aLevel, 'activeMenu' => $activeMenu]);
    }

    public function list(Request $request)
    {
        $aAdmins = AdminModel::select('id_admin', 'username', 'nip', 'no_telepon', 'email', 'nama', 'avatar')
            ->with('level');

        // if ($request -> nim) {
        //     $aAdmins->where('nim', $request->nim);
        // }

        return DataTables::of($aAdmins)
            ->addIndexColumn()
            ->addColumn('aksi', function ($aAdmin) {
                $btn = '<button onclick="modalAction(\'' . url('/aAdmin/' . $aAdmin->id_admin . '/show_ajax') . '\')" class="btn btn-info btn-sm" style="margin-right: 5px;">Detail</button>';
                $btn .= '<button onclick="modalAction(\'' . url('/aAdmin/' . $aAdmin->id_admin . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/aAdmin/' . $aAdmin->id_admin . '/delete_ajax') . '\')"  class="btn btn-danger btn-sm" style="margin-left: 5px;">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function show_ajax(string $id)
    {
        $aAdmin = AdminModel::find($id);

        return view('aAdmin.show_ajax', ['aAdmin' => $aAdmin]);
    }

    public function create_ajax()
    {
        $aLevel = LevelModel::select('id_level', 'nama_level')->get();

        return view('aAdmin.create_ajax')
            ->with('level', $aLevel);
    }

    public function store_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'id_level' => 'required|integer',
                'username' => 'required|string|max:30|unique:m_admin,username',
                'password' => 'nullable|min:5',
                'nip' => 'required|string|min:3|unique:m_admin,nip',
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

            AdminModel::create($data);

            return response()->json([
                'status' => true,
                'message' => 'Data berhasil disimpan'
            ]);
        }
        return redirect('/aAdmin');
    }

    public function edit_ajax(String $id)
    {
        $aAdmin = AdminModel::find($id);

        return view('aAdmin.edit_ajax', ['aAdmin' => $aAdmin]);
    }

    public function update_ajax(Request $request, $id)
    {
        // Cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
        } {
            $rules = [
                'id_level' => 'required|integer',
                'username' => 'required|string|max:30|unique:m_admin,username,' . $id . ',id_admin',
                'password' => 'nullable|min:5',
                'nip' => 'required|string|min:3|unique:m_admin,nip,' . $id . ',id_admin',
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

            $check = AdminModel::find($id);
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
        return redirect('/aAdmin');
    }

    public function confirm_ajax(String $id)
    {
        $aAdmin = AdminModel::find($id);

        return view('aAdmin.confirm_ajax', ['aAdmin' => $aAdmin]);
    }

    public function delete_ajax(Request $request, $id)
    {
        // cek apakah requset dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $aAdmin = AdminModel::find($id);
            if ($aAdmin) {
                $aAdmin->delete();
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
