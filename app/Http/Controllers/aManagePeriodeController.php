<?php

namespace App\Http\Controllers;

use App\Models\PeriodeAkademikModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class aManagePeriodeController extends Controller
{
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Manage Periode',
            'list' => ['Home', 'Manage Periode']
        ];

        $page = (object)[
            'title' => 'Manage Periode'
        ];

        $aManagePeriode = PeriodeAkademikModel::all();

        $activeMenu = 'aManagePeriode';

        return view('aManagePeriode.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'aManageJenisPenugasan' => $aManagePeriode, 'activeMenu' => $activeMenu]);
    }

    public function list(Request $request)
    {
        $aManagePeriode = PeriodeAkademikModel::select('id_periode', 'semester', 'tahun_ajaran');

        if ($request->semester) {
            $aManagePeriode->where('semester', $request->semester);
        }

        if ($request->tahun_ajaran) {
            $aManagePeriode->where('tahun_ajaran', $request->tahun_ajaran);
        }

        return DataTables::of($aManagePeriode)
            ->addIndexColumn()
            ->addColumn('aksi', function ($aManagePeriode) {
                $btn = '<button onclick="modalAction(\'' . url('/aManagePeriode/' . $aManagePeriode->id_periode . '/show_ajax') . '\')" class="btn btn-info btn-sm" style="margin-right: 5px;">Detail</button>';
                $btn .= '<button onclick="modalAction(\'' . url('/aManagePeriode/' . $aManagePeriode->id_periode . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button>';
                // $btn .= '<button onclick="modalAction(\'' . url('/aManageJenisPenugasan/' . $aManageJenisPenugasans->id_jenis_tugas . '/confirm_ajax') . '\')" class="btn btn-danger btn-sm" style="margin-left: 5px;">Delete</button>';
                $btn .= '<button onclick="modalAction(\'' . url('/aManagePeriode/' . $aManagePeriode->id_periode . '/delete_ajax') . '\')" class="btn btn-danger btn-sm" style="margin-left: 5px;">Delete</button>';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function show_ajax(string $id)
    {
        $aManagePeriode = PeriodeAkademikModel::find($id);

        if (!$aManagePeriode) {
            return response()->json([
                'status' => false,
                'message' => 'Data yang Anda cari tidak ditemukan.',
            ], 404);
        }

        return view('aManagePeriode.show_ajax', ['aManagePeriode' => $aManagePeriode]);
    }

    public function store_ajax(Request $request)
    {
        $request->validate([
            'semester' => 'required|in:ganjil,genap',
            'tahun_ajaran' => 'required|digits:4|integer',
        ]);

        // Cek apakah kombinasi semester dan tahun ajaran sudah ada
        $isExists = PeriodeAkademikModel::where('semester', $request->semester)
            ->where('tahun_ajaran', $request->tahun_ajaran)
            ->exists();

        if ($isExists) {
            return response()->json([
                'status' => false,
                'message' => 'Semester dan Tahun Ajaran sudah ada.'
            ]);
        }

        try {
            PeriodeAkademikModel::create([
                'semester' => $request->semester,
                'tahun_ajaran' => $request->tahun_ajaran,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Data berhasil disimpan'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
    }




    public function create_ajax()
    {
        $aManagePeriode = PeriodeAkademikModel::select('id_periode', 'semester', 'tahun_ajaran')->get();

        return view('aManagePeriode.create_ajax')
            ->with('aManagePeriode', $aManagePeriode);
    }

    // public function store_ajax(Request $request)
    // {
    //     if ($request->ajax() || $request->wantsJson()) {
    //         $rules = [
    //             'id_jenis_tugas' => 'required|integer',
    //             'jenis_tugas' => 'required|string|max:30|unique:m_jenis_tugas,jenis_tugas'
    //         ];

    //         $validator = Validator::make($request->all(), $rules);

    //         if ($validator->fails()) {
    //             return response()->json([
    //                 'status' => false,
    //                 'message' => 'Validasi Gagal',
    //                 'msgField' => $validator->errors(),
    //             ]);
    //         }

    //         // Hash password sebelum disimpan
    //         $data = $request->all();
    //         $data['password'] = bcrypt($request->password);

    //         JenisPenugasanModel::create($data);

    //         return response()->json([
    //             'status' => true,
    //             'message' => 'Data jenis penugasan berhasil disimpan'
    //         ]);
    //     }
    //     return redirect('/aManageJenisPenugasan');
    // }


    public function edit_ajax(string $id)
    {
        $aManagePeriode = PeriodeAkademikModel::find($id);

        return view('aManagePeriode.edit_ajax', ['aManagePeriode' => $aManagePeriode]);
    }

    public function update_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'semester' => 'required|in:ganjil,genap',
                'tahun_ajaran' => 'required|digits:5|integer',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status'   => false,
                    'message'  => 'Validasi gagal.',
                    'msgField' => $validator->errors()
                ]);
            }

            $check = PeriodeAkademikModel::find($id);

            if ($check) {
                $check->update([
                    'semester' => $request->semester,
                    'tahun_ajaran' => $request->tahun_ajaran,
                ]);

                return response()->json([
                    'status'  => true,
                    'message' => 'Data berhasil diupdate',
                    'data'    => $check // Kirim data terbaru
                ]);
            } else {
                return response()->json([
                    'status'  => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }
        return redirect('/aManagePeriode');
    }

    public function confirm_ajax(string $id)
    {
        $aManagePeriode = PeriodeAkademikModel::find($id);

        if (!$aManagePeriode) {
            return response()->json([
                'status'  => false,
                'message' => 'Data tidak ditemukan',
            ]);
        }

        return view('aManagePeriode.confirm_ajax', ['aManagePeriode' => $aManagePeriode]);
    }

    public function delete_ajax(Request $request, string $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $aManagePeriode = PeriodeAkademikModel::find($id);

            if ($aManagePeriode) {
                $aManagePeriode->delete();

                return response()->json([
                    'status'  => true,
                    'message' => 'Data berhasil dihapus',
                ]);
            } else {
                return response()->json([
                    'status'  => false,
                    'message' => 'Data tidak ditemukan',
                ]);
            }
        }

        return redirect('/aManagePeriode');
    }

    public function destroy(string $id)
    {
        $aManagePeriode = PeriodeAkademikModel::find($id);

        if (!$aManagePeriode) {
            return redirect('/aManagePeriode')->with('error', 'Data tidak ditemukan.');
        }

        try {
            $aManagePeriode->delete();

            return redirect('/aManagePeriode')->with('success', 'Data berhasil dihapus.');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/aManagePeriode')->with('error', 'Data gagal dihapus karena masih terkait dengan data lain.');
        }
    }
}
