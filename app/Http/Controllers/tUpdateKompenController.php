<?php

namespace App\Http\Controllers;

use App\Models\RiwayatKompenModel;
use App\Models\TugasKompenModel;
use App\Models\AlphaModel;
use App\Models\ProgresTugasModel;
use Illuminate\Support\Facades\Log;


use Illuminate\Http\Request;

class tUpdateKompenController extends Controller
{
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Update Kompen Selesai',
            'list' => ['Home', 'Update Kompen Selesai']
        ];

        $page = (object)[
            'title' => 'Pantau progres mahasiswa dan klik selesai apabila tugas yang dilakukan telah selesai.'
        ];

        $activeMenu = 'tUpdateKompen';

        $riwayatKompen = RiwayatKompenModel::with(['tugasKompen', 'progresTugas'])->get();

        $data = [];
        foreach ($riwayatKompen as $riwayat) {
            $tugasKompen = $riwayat->tugasKompen;
            $progresTugas = $riwayat->progresTugas;

            $pemberiTugas = null;
            $namaTugas = '-';
            $progres = '-';
            $fileUpload = $riwayat->file_upload ?? null;
            $status = $riwayat->status ?? '-';

            if ($tugasKompen) {
                if ($tugasKompen->tugasAdmin) {
                    $pemberiTugas = $tugasKompen->tugasAdmin->admin->nama ?? 'Unknown Admin';
                    $namaTugas = $tugasKompen->tugasAdmin->nama_tugas ?? '-';
                } elseif ($tugasKompen->tugasDosen) {
                    $pemberiTugas = $tugasKompen->tugasDosen->dosen->nama ?? 'Unknown Dosen';
                    $namaTugas = $tugasKompen->tugasDosen->nama_tugas ?? '-';
                } elseif ($tugasKompen->tugasTendik) {
                    $pemberiTugas = $tugasKompen->tugasTendik->tendik->nama ?? 'Unknown Tendik';
                    $namaTugas = $tugasKompen->tugasTendik->nama_tugas ?? '-';
                }
            }

            if ($progresTugas) {
                $progres = $progresTugas->progress ?? '-';
            }

            $data[] = [
                'no' => count($data) + 1,
                'nama_tugas' => $namaTugas,
                'nama_mahasiswa' => $tugasKompen->mahasiswa->nama ?? 'Nama Mahasiswa Tidak Ditemukan',
                'pemberi_tugas' => $pemberiTugas,
                'progres' => $progres,
                'berita_acara' => $fileUpload ? asset('storage/' . $fileUpload) : null,
                'status' => $status,
                'id_riwayat' => $riwayat->id_riwayat,
                'id_progres_tugas' => $progresTugas->id_progres_tugas ?? null
            ];
        }

        return view('tUpdateKompen.index', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu,
            'data' => $data
        ]);
    }

    public function TugasSelesai($idProgres)
    {
        try {
            $progresTugas = ProgresTugasModel::findOrFail($idProgres);
            $progresTugas->status_progres = 'selesai';
            $progresTugas->save();

            return redirect()->back()->with('success', 'Status progres berhasil diubah menjadi selesai.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengubah status progres: ' . $e->getMessage());
        }
    }
}
