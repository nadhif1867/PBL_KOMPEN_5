<?php

namespace App\Http\Controllers;

use App\Models\TugasKompen;
use App\Models\TugasKompenModel;
use Illuminate\Http\Request;

class aTugasKompenController extends Controller
{
    /**
     * Function untuk menampilkan halaman index.
     */
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Daftar Tugas Tendik',
            'list' => ['Home', 'Tugas Tendik']
        ];

        $page = (object)[
            'title' => 'Daftar Tugas Tendik',
        ];

        $activeMenu = 'aTugasTendik';
        // Return view untuk halaman manajemen Tugas Kompen
        return view('aTugasKompen.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }

    /**
     * Function untuk mengambil daftar tugas kompen (digunakan untuk AJAX DataTables).
     */
    public function list(Request $request)
    {
        // Mengambil data tugas kompen beserta relasi
        $tugasKompen = TugasKompenModel::with(['tugasadmin', 'tugasdosen', 'tugastendik'])->get();

        // Format data untuk DataTables
        $data = $tugasKompen->map(function ($item) {
            return [
                'id' => $item->id_tugas_kompen,
                'pemberi_kompen' => $item->tugasadmin->nama ??
                    $item->tugasdosen->nama ??
                    $item->tugastendik->nama ?? '-',
                'jenis_tugas' => $item->jenis_tugas ?? '-',
                'deskripsi' => $item->deskripsi ?? '-',
                'kuota' => $item->kuota ?? '-',
                'jam_kompen' => $item->jam_kompen ?? '-',
                'status' => $item->status_penerimaan ?? '-',
                'waktu_pengerjaan' => $item->tanggal_mulai . ' - ' . $item->tanggal_selesai,
                'tag_kompetensi' => $item->tag_bidkom ?? '-',
            ];
        });

        // Kirim data dalam format JSON
        return response()->json([
            'data' => $data
        ]);
    }

    /**
     * Function untuk mengambil detail tugas kompen berdasarkan ID (digunakan untuk AJAX).
     */
    public function show_ajax($id)
    {
        // Cari tugas kompen berdasarkan ID
        $tugasKompen = TugasKompenModel::with(['tugasadmin', 'tugasdosen', 'tugastendik'])->find($id);

        // Jika data tidak ditemukan
        if (!$tugasKompen) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        // Format data detail
        $data = [
            'id' => $tugasKompen->id_tugas_kompen,
            'pemberi_kompen' => $tugasKompen->tugasddmin->nama ??
                $tugasKompen->tugasdosen->nama ??
                $tugasKompen->tugastendik->nama ?? '-',
            'jenis_tugas' => $tugasKompen->jenis_tugas ?? '-',
            'deskripsi' => $tugasKompen->deskripsi ?? '-',
            'kuota' => $tugasKompen->kuota ?? '-',
            'jam_kompen' => $tugasKompen->jam_kompen ?? '-',
            'status' => $tugasKompen->status_penerimaan ?? '-',
            'waktu_pengerjaan' => $tugasKompen->tanggal_mulai . ' - ' . $tugasKompen->tanggal_selesai,
            'tag_kompetensi' => $tugasKompen->tag_bidkom ?? '-',
        ];

        // Kirim data detail dalam format JSON
        return response()->json($data);
    }
}
