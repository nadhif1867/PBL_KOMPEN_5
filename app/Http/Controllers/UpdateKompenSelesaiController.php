<?php

namespace App\Http\Controllers;

use App\Models\RiwayatKompenModel;
use App\Models\TugasAdminModel;
use App\Models\TugasDosenModel;
use App\Models\TugasTendikModel;
use App\Models\ProgresTugasModel;
use App\Models\TugasKompenModel;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class UpdateKompenSelesaiController extends Controller
{
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Upload Berita Acara',
            'list' => ['Home', 'Update Kompen Selesai']
        ];

        $page = (object)[
            'title' => 'Silakan unggah surat berita acara yang telah ditandatangani pada kolom aksi.'
        ];

        $activeMenu = 'mUpdateKompenSelesai';

        $userId = auth('mahasiswa')->id();

        $tugasKompen = TugasKompenModel::where('id_mahasiswa', $userId)
            ->where('status_penerimaan', 'diterima')
            ->with(['tugasAdmin.admin', 'tugasDosen.dosen', 'tugasTendik.tendik'])
            ->get();

        $data = [];

        foreach ($tugasKompen as $tugas) {
            $pemberiTugas = null;
            $nama_tugas = '';
            $jamKompen = '';
            $waktuPengerjaan = '';
            $status = '-';
            $file_upload = null;

            if ($tugas->tugasAdmin) {
                $pemberiTugas = $tugas->tugasAdmin->admin->nama ?? 'Unknown Admin';
                $nama_tugas = $tugas->tugasAdmin->nama_tugas;
                $jamKompen = $tugas->tugasAdmin->jam_kompen;
                $waktuPengerjaan = Carbon::parse($tugas->tugasAdmin->tanggal_mulai)->format('d-m-Y') . ' - ' . Carbon::parse($tugas->tugasAdmin->tanggal_selesai)->format('d-m-Y');
            } elseif ($tugas->tugasDosen) {
                $pemberiTugas = $tugas->tugasDosen->dosen->nama ?? 'Unknown Dosen';
                $nama_tugas = $tugas->tugasDosen->nama_tugas;
                $jamKompen = $tugas->tugasDosen->jam_kompen;
                $waktuPengerjaan = Carbon::parse($tugas->tugasDosen->tanggal_mulai)->format('d-m-Y') . ' - ' . Carbon::parse($tugas->tugasDosen->tanggal_selesai)->format('d-m-Y');
            } elseif ($tugas->tugasTendik) {
                $pemberiTugas = $tugas->tugasTendik->tendik->nama ?? 'Unknown Tendik';
                $nama_tugas = $tugas->tugasTendik->nama_tugas;
                $jamKompen = $tugas->tugasTendik->jam_kompen;
                $waktuPengerjaan = Carbon::parse($tugas->tugasTendik->tanggal_mulai)->format('d-m-Y') . ' - ' . Carbon::parse($tugas->tugasTendik->tanggal_selesai)->format('d-m-Y');
            }

            $riwayatKompen = RiwayatKompenModel::where('id_tugas_kompen', $tugas->id_tugas_kompen)->first();
            if ($riwayatKompen) {
                $status = $riwayatKompen->status ?? '-';
                $file_upload = $riwayatKompen->file_upload ?? null;
            }

            $data[] = (object)[ //yang tampil ke view
                'no' => count($data) + 1,
                'pemberi_kompen' => $pemberiTugas,
                'nama_tugas' => $nama_tugas,
                'status' => $status,
                'jam_kompen' => $jamKompen,
                'waktu_pengerjaan' => $waktuPengerjaan,
                'id_tugas_kompen' => $tugas->id_tugas_kompen,
                'file_upload' => $file_upload
            ];
        }

        return view('mUpdateKompenSelesai.index', compact('breadcrumb', 'page', 'activeMenu', 'data'));
    }

    public function upload(Request $request, $id_riwayat)
    {
        $request->validate([
            'file' => 'required|file|max:2048' // Max 2MB
        ]);

        try {
            $riwayatKompen = RiwayatKompenModel::where('id_tugas_kompen', $id_riwayat)->firstOrFail();

            $filePath = $request->file('file')->store('berita_acara', 'public');

            $riwayatKompen->status = 'belum_diterima';
            $riwayatKompen->file_upload = $filePath;
            $riwayatKompen->save();

            return redirect()->back()->with('success', 'File berhasil diunggah');
        }   catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengunggah file: ' . $e->getMessage());
        }
    }
}
