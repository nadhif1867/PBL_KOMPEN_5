<?php

namespace App\Http\Controllers;

use App\Models\ProgresTugasModel;
use App\Models\RiwayatKompenModel;
use App\Models\TugasKompenModel;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class aDikerjakanOlehController extends Controller
{
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Manage Kompen',
            'list' => ['Home', 'Manage Kompen']
        ];

        $page = (object)[
            'title' => 'Manage Kompen',
        ];

        $activeMenu = 'aDikerjakanOleh';
        return view('aDikerjakanOleh.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }

    public function list(Request $request)
    {
        // Ambil data  status_penerimaan = 'request'
        $aManageKompens = TugasKompenModel::select('id_tugas_kompen', 'id_mahasiswa', 'id_tugas_admin', 'status_penerimaan')
            ->where('status_penerimaan', 'request')
            ->whereNotNull('id_tugas_admin')
            ->with('mahasiswa')
            ->with('tugasadmin');

        return DataTables::of($aManageKompens)
            ->addIndexColumn()
            ->addColumn('aksi', function ($aManageKompen) {
                $btn = '<button onclick="updateStatus(' . $aManageKompen->id_tugas_kompen . ', \'diterima\')" class="btn btn-success btn-sm" style="margin-top: 5px;">Diterima</button>';
                $btn .= '<button onclick="updateStatus(' . $aManageKompen->id_tugas_kompen . ', \'ditolak\')" class="btn btn-danger btn-sm" style="margin-top: 5px;">Tolak</button>';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function updateStatus(Request $request)
{
    $id = $request->input('id');
    $status = $request->input('status');

    // Validasi input status
    if (!in_array($status, ['diterima', 'ditolak'])) {
        return response()->json(['success' => false, 'message' => 'Status tidak valid.']);
    }

    // Cari data berdasarkan ID
    $kompen = TugasKompenModel::find($id);
    if ($kompen) {
        // Update status
        $kompen->status_penerimaan = $status;
        $kompen->save();

        if ($status === 'diterima') {
            try {
                // Buat data di t_progres_tugas
                $progresTugas = ProgresTugasModel::create([
                    'id_tugas_kompen' => $kompen->id_tugas_kompen,
                    'status_progres' => 'progres',
                    'progress' => '0'
                ]);

                if ($progresTugas) {
                    RiwayatKompenModel::create([
                        'id_tugas_kompen' => $kompen->id_tugas_kompen,
                        'id_progres_tugas' => $progresTugas->id_progres_tugas,
                        'status' => 'belum_diterima',
                        'file_upload' => null,
                    ]);
                }

                return response()->json(['success' => true, 'message' => 'Progres dan Riwayat berhasil dibuat.']);
            } catch (\Exception $e) {
                return response()->json(['success' => false, 'message' => 'Gagal membuat progres/riwayat tugas: ' . $e->getMessage()]);
            }
        }

        return response()->json(['success' => true, 'message' => 'Status berhasil diperbarui.']);
    }

    return response()->json(['success' => false, 'message' => 'Data tidak ditemukan.']);
}
}
