<?php

namespace App\Http\Controllers;

use App\Models\LevelModel;
use App\Models\MahasiswaModel;
use Illuminate\Support\Facades\validator;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class aMahasiswaController extends Controller
{
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Daftar User Mahasiswa',
            'list' => ['Home', 'User Mahasiswa']
        ];

        $page = (object)[
            'title' => 'Daftar Mahasiswa',
        ];

        $aLevel = LevelModel::all();

        $activeMenu = 'aMahasiswa';

        return view('aMahasiswa.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'aLevel' => $aLevel, 'activeMenu' => $activeMenu]);
    }

    public function list(Request $request)
    {
        $aMahasiswas = MahasiswaModel::select('id_mahasiswa', 'username', 'nim', 'prodi', 'email', 'tahun_masuk', 'no_telepon', 'nama', 'avatar')
            ->with('level');

        // if ($request -> nim) {
        //     $aMahasiswas->where('nim', $request->nim);
        // }

        return DataTables::of($aMahasiswas)
            ->addIndexColumn()
            ->addColumn('aksi', function ($aMahasiswa) {
                $btn = '<button onclick="modalAction(\'' . url('/aMahasiswa/' . $aMahasiswa->id_mahasiswa . '/show_ajax') . '\')" class="btn btn-info btn-sm" style="margin-right: 5px;">Detail</button>';
                $btn .= '<button onclick="modalAction(\'' . url('/aMahasiswa/' . $aMahasiswa->id_mahasiswa .'/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/aMahasiswa/' . $aMahasiswa->id_mahasiswa .'/delete_ajax') . '\')"  class="btn btn-danger btn-sm" style="margin-left: 5px;">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function show_ajax(string $id)
    {
        $aMahasiswa = MahasiswaModel::find($id);

        return view('aMahasiswa.show_ajax', ['aMahasiswa' => $aMahasiswa]);
    }

    // Method untuk tabel m_mahasiswa
    public function create_ajax()
    {
        $aLevel = LevelModel::select('id_level', 'nama_level')->get();

        return view('aMahasiswa.create_ajax')
            ->with('level', $aLevel);
    }

    public function store_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'id_level' => 'required|integer',
                'username' => 'required|string|max:30|unique:m_mahasiswa,username',
                'password' => 'required|min:5',
                'nim' => 'required|string|min:3|unique:m_mahasiswa,nim',
                'prodi' => 'required|string|min:3',
                'email' => 'required|string|',
                'tahun_masuk' => 'required|integer|',
                'no_telepon' => 'required|string|',
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

            MahasiswaModel::create($data);

            return response()->json([
                'status' => true,
                'message' => 'Data mahasiswa berhasil disimpan'
            ]);
        }
        return redirect('/aMahasiswa');
    }
}
