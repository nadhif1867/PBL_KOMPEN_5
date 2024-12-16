<?php

namespace App\Http\Controllers;

use App\Models\AdminModel;
use App\Models\AlphaModel;
use App\Models\MahasiswaModel;
use App\Models\PeriodeAkademikModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Yajra\DataTables\Facades\DataTables;

class aManageMahasiswaKompenController extends Controller
{
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Manage Data Mahasiswa Kompen',
            'list' => ['Home', 'Mahasiswa Kompen']
        ];

        $page = (object)[
            'title' => 'Manage Data Mahasiswa Kompen',
        ];

        $aMahasiswa = MahasiswaModel::all();
        $aPeriodeAkademik = PeriodeAkademikModel::all();

        $activeMenu = 'aManageMahasiswaKompen';

        return view('aManageMahasiswaKompen.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'aMahasiswa' => $aMahasiswa, 'aPeriodeAkademik' => $aPeriodeAkademik, 'activeMenu' => $activeMenu]);
    }

    public function list(Request $request)
    {
        $aManageMahasiswaKompens = AlphaModel::select('id_alpha', 'id_mahasiswa', 'jumlah_alpha', 'kompen_dibayar', 'id_periode')
            ->with('mahasiswa')
            ->with('periode');

        // if ($request -> nim) {
        //     $aDosens->where('nim', $request->nim);
        // }

        return DataTables::of($aManageMahasiswaKompens)
            ->addIndexColumn()
            ->addColumn('aksi', function ($aManageMahasiswaKompen) {
                $btn = '<button onclick="modalAction(\'' . url('/aManageMahasiswaKompen/' . $aManageMahasiswaKompen->id_alpha . '/show_ajax') . '\')" class="btn btn-info btn-sm" style="margin-right: 10px;">Detail</button>';
                $btn .= '<button onclick="modalAction(\'' . url('/aManageMahasiswaKompen/' . $aManageMahasiswaKompen->id_alpha . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button>';
                $btn .= '<button onclick="modalAction(\'' . url('/aManageMahasiswaKompen/' . $aManageMahasiswaKompen->id_alpha . '/delete_ajax') . '\')" class="btn btn-danger btn-sm" style="margin-left: 10px;">Delete</button>';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function show_ajax(string $id)
    {
        $aManageMahasiswaKompen = AlphaModel::find($id);

        return view('aManageMahasiswaKompen.show_ajax', ['aManageMahasiswaKompen' => $aManageMahasiswaKompen]);
    }

    public function create_ajax()
    {
        // $aManageMahasiswaKompen = AlphaModel::select('id_alpha', 'id_mahasiswa', 'jumlah_alpha', 'kompen_dibayar', 'periode')->get();
        $aMahasiswa = MahasiswaModel::select('id_mahasiswa', 'nama')->get();
        $aPeriodeAkademik = PeriodeAkademikModel::select('id_periode', 'tahun_ajaran')->get();

        return view('aManageMahasiswaKompen.create_ajax')
            ->with('aMahasiswa', $aMahasiswa)
            ->with('aPeriodeAkademik', $aPeriodeAkademik);
    }

    public function store_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'id_mahasiswa' => 'required|integer',
                'jumlah_alpha' => 'required|integer',
                'kompen_dibayar' => 'required|integer',
                'id_periode' => 'required|integer'
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(),
                ]);
            }

            AlphaModel::create($request->all());

            return response()->json([
                'status' => true,
                'message' => 'Data berhasil disimpan'
            ]);
        }
        return redirect('/aManageMahasiswaKompen');
    }

    public function edit_ajax(String $id)
    {
        $aManageMahasiswaKompen = AlphaModel::find($id);

        return view('aManageMahasiswaKompen.edit_ajax', ['aManageMahasiswaKompen' => $aManageMahasiswaKompen]);
    }

    public function update_ajax(Request $request, $id)
    {
        // Cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
        } {
            $rules = [
                'jumlah_alpha' => 'required|integer',
                'kompen_dibayar' => 'required|integer',
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
        return redirect('/aManageMahasiswaKompen');
    }

    public function confirm_ajax(String $id)
    {
        $aManageMahasiswaKompen = AlphaModel::find($id);
        $aMahasiswa = MahasiswaModel::select('id_mahasiswa', 'nama', 'nim', 'prodi')->get();

        return view('aManageMahasiswaKompen.confirm_ajax', ['aManageMahasiswaKompen' => $aManageMahasiswaKompen])
            ->with('mahasiswa');
    }

    public function delete_ajax(Request $request, $id)
    {
        // cek apakah requset dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $aManageMahasiswaKompen = AlphaModel::find($id);
            if ($aManageMahasiswaKompen) {
                $aManageMahasiswaKompen->delete();
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
        return redirect('/aManageMahasiswaKompen');
    }

    public function import()
    {
        return view('aManageMahasiswaKompen.import');
    }

    public function import_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                // validasi file harus xls atau xlsx, max 1MB
                'file_kompen' => ['required', 'mimes:xlsx', 'max:2048']
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            $file = $request->file('file_kompen');  // ambil file dari request

            $reader = IOFactory::createReader('Xlsx');  // load reader file excel
            $reader->setReadDataOnly(true);             // hanya membaca data
            $spreadsheet = $reader->load($file->getRealPath()); // load file excel
            $sheet = $spreadsheet->getActiveSheet();    // ambil sheet yang aktif

            $data = $sheet->toArray(null, false, true, true);   // ambil data excel

            $insert = [];
            if (count($data) > 1) { // jika data lebih dari 1 baris
                foreach ($data as $baris => $value) {
                    if ($baris > 1) { // baris ke 1 adalah header, maka lewati
                        $insert[] = [
                            'id_alpha' => $value['A'],
                            'id_mahasiswa' => $value['B'],
                            'jumlah_alpha' => $value['C'],
                            'kompen_dibayar' => $value['D'],
                            'id_periode' => $value['E'],
                        ];
                    }
                }

                if (count($insert) > 0) {
                    // insert data ke database, jika data sudah ada, maka diabaikan
                    AlphaModel::insertOrIgnore($insert);
                }

                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil diimport'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Tidak ada data yang diimport'
                ]);
            }
        }
        return redirect('/aManageMahasiswaKompen');
    }
}
