<?php

namespace App\Http\Controllers;

use App\Models\AlphaModel;
use App\Models\MahasiswaModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
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

    public function import()
    {
        return view('aMahasiswaKompen.import');
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
        return redirect('/aMahasiswaKompen');
    }
}
