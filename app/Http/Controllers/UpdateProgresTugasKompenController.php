<?php

namespace App\Http\Controllers;

use App\Models\TugasKompenModel;
use App\Models\TugasAdminModel;
use App\Models\TugasDosenModel;
use App\Models\TugasTendikModel;
use App\Models\ProgresTugasModel;
use App\Models\MahasiswaModel;
use App\Models\AdminModel;
use App\Models\TendikModel;
use App\Models\DosenModel;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

use Illuminate\Http\Request;

class UpdateProgresTugasKompenController extends Controller
{
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Update Progress Penugasan',
            'list' => ['Home', 'Update Progress Penugasan']
        ];

        $page = (object)[
            'title' => 'Update Progress Penugasan'
        ];

        $activeMenu = 'mUpdateProgressTugasKompen';

        $userId = auth('mahasiswa')->id();

        $progressData = ProgresTugasModel::select('id_tugas_kompen', 'progress')
            ->get();
            // dd($progressData);

        $tugasKompen = TugasKompenModel::select('id_tugas_kompen', 'id_mahasiswa', 'id_tugas_admin', 'id_tugas_dosen', 'id_tugas_tendik', 'status_penerimaan', 'tanggal_apply')
            ->where('id_mahasiswa', $userId)
            ->where('status_penerimaan', 'diterima')
            ->get();

        $data = [];
        foreach ($progressData as $progress) {
            $tugas = $tugasKompen->first(function ($item) use ($progress) {
                return $item->id_tugas_kompen == $progress->id_tugas_kompen;
            });

            if ($tugas) {
                $pemberiTugas = null;
                $nama_tugas = '';
                $jamKompen = '';
                $waktuPengerjaan = '';

                // Tentukan pemberi tugas dan informasi lainnya berdasarkan id_tugas
                if ($tugas->id_tugas_admin) {
                    $task = TugasAdminModel::find($tugas->id_tugas_admin);
                    $pemberiTugas = $task->admin->nama ?? 'Unknown Admin';
                    $nama_tugas = $task->nama_tugas;
                    $jamKompen = $task->jam_kompen;
                    $waktuPengerjaan = Carbon::parse($task->tanggal_mulai)->format('d-m-Y') . ' - ' . Carbon::parse($task->tanggal_selesai)->format('d-m-Y');
                } elseif ($tugas->id_tugas_dosen) {
                    $task = TugasDosenModel::find($tugas->id_tugas_dosen);
                    $pemberiTugas = $task->dosen->nama ?? 'Unknown Dosen';
                    $nama_tugas = $task->nama_tugas;
                    $jamKompen = $task->jam_kompen;
                    $waktuPengerjaan = Carbon::parse($task->tanggal_mulai)->format('d-m-Y') . ' - ' . Carbon::parse($task->tanggal_selesai)->format('d-m-Y');
                } elseif ($tugas->id_tugas_tendik) {
                    $task = TugasTendikModel::find($tugas->id_tugas_tendik);
                    $pemberiTugas = $task->tendik->nama ?? 'Unknown Tendik';
                    $nama_tugas = $task->nama_tugas;
                    $jamKompen = $task->jam_kompen;
                    $waktuPengerjaan = Carbon::parse($task->tanggal_mulai)->format('d-m-Y') . ' - ' . Carbon::parse($task->tanggal_selesai)->format('d-m-Y');
                }

                // Gabungkan data untuk view
                $data[] = (object)[
                    'no' => count($data) + 1,
                    'pemberi_kompen' => $pemberiTugas,
                    'nama_tugas' => $nama_tugas,
                    'status' => $tugas->status_penerimaan,
                    'jam_kompen' => $jamKompen,
                    'waktu_pengerjaan' => $waktuPengerjaan,
                    'progres' => $progress->progress ?? '-',
                    'id_tugas_kompen' => $tugas->id_tugas_kompen
                ];
            }
        }

        return view('mUpdateProgresTugasKompen.index', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu,
            'progressData' => $data
        ]);
    }

    public function fetchTugasData($id)
    {
        $task = TugasKompenModel::find($id);

        // Ensure task exists
        if (!$task) {
            return response()->json(['error' => 'Task not found'], 404);
        }

        // Return modal content
        return view('mUpdateProgresTugasKompen.update_progres', compact('task'));
    }

    // public function updateProgress(Request $request, $id)
    // {
    //     $request->validate([
    //         'progress' => 'required|string|max:255'
    //     ]);

    //     $task = ProgresTugasModel::where('id_tugas_kompen', $id)->first();
    //     if (!$task) {
    //         return response()->json(['error' => 'Task not found'], 404);
    //     }

    //     // Update progress
    //     $task->progress = $request->input('progress');
    //     $task->save();

    //     return response()->json(['success' => true, 'message' => 'Progress updated successfully']);
    // }

    public function updateProgress(Request $request, $id)
{
    $request->validate([
        'progress' => 'required|numeric|min:0|max:100',
    ], [
        'progress.required' => 'Progres tidak boleh kosong.',
        'progress.numeric' => 'Progres harus berupa angka.',
        'progress.min' => 'Nilai progres tidak valid, harus antara 0-100%',
        'progress.max' => 'Nilai progres tidak valid, harus antara 0-100%',
    ]);

    $task = ProgresTugasModel::where('id_tugas_kompen', $id)->first();
    if (!$task) {
        return response()->json(['message' => 'Tugas tidak ditemukan.'], 404);
    }

    $task->progress = $request->input('progress');
    $task->save();

    return response()->json(['success' => true, 'message' => 'Update Progres Tugas Kompen']);
}
    public function qrcodeGenerate($id)
{
    // Ambil data tugas berdasarkan ID
    $tugasKompen = TugasKompenModel::find($id);
    if (!$tugasKompen) {
        return response()->json(['error' => 'Tugas tidak ditemukan'], 404);
    }

    // Ambil data mahasiswa berdasarkan ID
    $mahasiswa = MahasiswaModel::find($tugasKompen->id_mahasiswa);
    if (!$mahasiswa) {
        return response()->json(['error' => 'Mahasiswa tidak ditemukan'], 404);
    }

    // Nama file PDF yang mengandung NIM mahasiswa
    $nim = $mahasiswa->nim;
    $fileName = 'surat_berita_acara_' . $nim . '.pdf';

    // Path file surat berita acara
    $fileUrl = Storage::url('surat_berita_acara/' . $fileName); // File ini harus sudah ada di storage

    // Membuat QR Code yang mengarah ke URL file
    $qrCodePath = 'public/qr_codes/qr_code_' . $nim . '.png';
    $qrCodeUrl = Storage::url($qrCodePath);

    // Generate QR Code jika belum ada
    if (!Storage::exists($qrCodePath)) {
        $qrCode = QrCode::size(250)->generate(url($fileUrl));
        Storage::put($qrCodePath, $qrCode);
    }

    // Kembalikan view dengan QR Code URL
    return view('mUpdateProgresTugasKompen.cetak_berita_acara', [
        'qrCode' => url($qrCode), // Pastikan ini dikirim ke view
        'nama_pengajar' => 'Nama Pengajar', // Ganti dengan data yang sesuai
        'nip_pengajar' => 'NIP Pengajar', // Ganti dengan data yang sesuai
        'nama_mahasiswa' => $mahasiswa->nama, // Nama mahasiswa
        'nim' => $mahasiswa->nim, // NIM mahasiswa
        'kelas' => $mahasiswa->kelas, // Kelas mahasiswa
        'semester' => $mahasiswa->semester, // Semester mahasiswa
        'pekerjaan' => 'Nama Tugas', // Nama tugas
        'jumlah_jam' => 'Jumlah Jam', // Jumlah jam
        'tanggal' => now()->format('d F Y') // Tanggal saat ini

    ]);
}
    public function export_pdf($id)
    {
        // Ambil data tugas berdasarkan ID
        $tugasKompen = TugasKompenModel::find($id);
        if (!$tugasKompen) {
            abort(404, 'Data tugas tidak ditemukan');
        }

        // Ambil data mahasiswa berdasarkan id_mahasiswa
        $mahasiswa = MahasiswaModel::find($tugasKompen->id_mahasiswa);
        // $mahasiswa = \DB::table('m_mahasiswa')->where('id', $tugasKompen->id_mahasiswa)->first();
        if (!$mahasiswa) {
            abort(404, 'Data mahasiswa tidak ditemukan');
        }
        $nim = $mahasiswa->nim;
        $fileUrl = url('/storage/surat_berita_acara/Berita Acara Kompensasi.pdf');
        $qrCode = QrCode::size(150)->generate($fileUrl);

        // Inisialisasi variabel tugas
        // $pemberiTugas = '';
        $namaPemberiTugas = '';
        $namaTugas = '';
        $jamKompen = '';
        $nipPemberiTugas = '';
        $waktuPengerjaan = '';

        // Tentukan jenis tugas dan ambil detailnya
        if ($tugasKompen->id_tugas_admin) {
            $task = TugasAdminModel::find($tugasKompen->id_tugas_admin);
            if ($task) {
                $admin = AdminModel::find($task->id_admin);
                $namaPemberiTugas = $admin ? $admin->nama : 'Admin tidak ditemukan';
                $nipPemberiTugas = $admin ? $admin->nip : 'NIP tidak ditemukan';
                $namaTugas = $task->nama_tugas;
                $jamKompen = $task->jam_kompen;
            }
        } elseif ($tugasKompen->id_tugas_dosen) {
            $task = TugasDosenModel::find($tugasKompen->id_tugas_dosen);
            if ($task) {
                $dosen = DosenModel::find($task->id_dosen);
                $namaPemberiTugas = $dosen ? $dosen->nama : 'Dosen tidak ditemukan';
                $nipPemberiTugas = $dosen ? $dosen->nip : 'NIP tidak ditemukan';
                $namaTugas = $task->nama_tugas;
                $jamKompen = $task->jam_kompen;
            }
        } elseif ($tugasKompen->id_tugas_tendik) {
            $task = TugasTendikModel::find($tugasKompen->id_tugas_tendik);
            if ($task) {
                $tendik = TendikModel::find($task->id_tendik);
                $namaPemberiTugas = $tendik ? $tendik->nama : 'Tendik tidak ditemukan';
                $nipPemberiTugas = $tendik ? $tendik->nip : 'NIP tidak ditemukan';
                $namaTugas = $task->nama_tugas;
                $jamKompen = $task->jam_kompen;
            }
        }

        // Data untuk view PDF
        $data = [
            'nama_pengajar' => $namaPemberiTugas,
            'nip_pengajar' => $nipPemberiTugas,
            'nama_mahasiswa' => $mahasiswa->nama,
            'nim' => $mahasiswa->nim,
            'kelas' => $mahasiswa->kelas,
            'semester' => $mahasiswa->semester,
            'pekerjaan' => $namaTugas,
            'jumlah_jam' => $jamKompen,
            'tanggal' => date('d F Y'),
            'qrCode' => $qrCode
        ];


        // Load view untuk PDF
        $pdf = Pdf::loadView('mUpdateProgresTugasKompen.cetak_berita_acara', $data);

        // Set ukuran kertas dan orientasi
        $pdf->setPaper('a4', 'portrait');

        // Stream atau download PDF
        return $pdf->stream('Berita Acara Kompensasi.pdf');
    }

    public function show($id)
{
    // Ambil data tugas berdasarkan ID
    $tugasKompen = TugasKompenModel::find($id);
    if (!$tugasKompen) {
        abort(404, 'Data tugas tidak ditemukan');
    }

    // Ambil data mahasiswa
    $mahasiswa = MahasiswaModel::find($tugasKompen->id_mahasiswa);
    if (!$mahasiswa) {
        abort(404, 'Data mahasiswa tidak ditemukan');
    }

    // URL file PDF atau informasi lainnya yang akan dimasukkan dalam QR Code
    $fileUrl = url('/storage/surat_berita_acara/surat_berita_acara_' . $mahasiswa->nim . '.pdf');

    // Generate QR Code sebagai SVG
    $qrCode = QrCode::size(200)->generate($fileUrl);

    // Kirim QR Code ke view
    return view('mUpdateProgresTugasKompen.qr_code_view', compact('qrCode', 'fileUrl'));
}

}
