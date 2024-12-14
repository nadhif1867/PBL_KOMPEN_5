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

        $userId = 3;
        
        $progressData = ProgresTugasModel::select('id_tugas_kompen', 'progress')
            ->get();

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

        if (!$task) {
            return response()->json(['error' => 'Task not found'], 404);
        }

        return view('mUpdateProgresTugasKompen.update_progres', compact('task'));
    }

    public function updateProgress(Request $request, $id)
    {
        $request->validate([
            'progress' => 'required|string|max:255'
        ]);

        $task = ProgresTugasModel::where('id_tugas_kompen', $id)->first();
        if (!$task) {
            return response()->json(['error' => 'Task not found'], 404);
        }

        $task->progress = $request->input('progress');
        $task->save();

        return response()->json(['success' => true, 'message' => 'Progress updated successfully']);
    }

    public function qrcodeGenerate($id)
{
    $tugasKompen = TugasKompenModel::find($id);
    if (!$tugasKompen) {
        return response()->json(['error' => 'Tugas tidak ditemukan'], 404);
    }

    $mahasiswa = MahasiswaModel::find($tugasKompen->id_mahasiswa);
    if (!$mahasiswa) {
        return response()->json(['error' => 'Mahasiswa tidak ditemukan'], 404);
    }

    $nim = $mahasiswa->nim;
    $fileName = 'surat_berita_acara_' . $nim . '.pdf';

    $fileUrl = Storage::url('surat_berita_acara/' . $fileName);

    $qrCodePath = 'public/qr_codes/qr_code_' . $nim . '.png';
    $qrCodeUrl = Storage::url($qrCodePath);

    if (!Storage::exists($qrCodePath)) {
        $qrCode = QrCode::size(250)->generate(url($fileUrl));
        Storage::put($qrCodePath, $qrCode);
    }

    // Kembalikan view dengan QR Code URL
    return view('mUpdateProgresTugasKompen.cetak_berita_acara', [
        'qrCode' => url($qrCode),
        'nama_pengajar' => 'Nama Pengajar',
        'nip_pengajar' => 'NIP Pengajar',
        'nama_mahasiswa' => $mahasiswa->nama,
        'nim' => $mahasiswa->nim,
        'kelas' => $mahasiswa->kelas,
        'semester' => $mahasiswa->semester,
        'pekerjaan' => 'Nama Tugas',
        'jumlah_jam' => 'Jumlah Jam',
        'tanggal' => now()->format('d F Y')

    ]);
}
    public function export_pdf($id)
    {
        $tugasKompen = TugasKompenModel::find($id);
        if (!$tugasKompen) {
            abort(404, 'Data tugas tidak ditemukan');
        }

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

        $pdf = Pdf::loadView('mUpdateProgresTugasKompen.cetak_berita_acara', $data);
        $pdf->setPaper('a4', 'portrait');
        return $pdf->stream('Berita Acara Kompensasi.pdf');
    }

    public function show($id)
{
    $tugasKompen = TugasKompenModel::find($id);
    if (!$tugasKompen) {
        abort(404, 'Data tugas tidak ditemukan');
    }

    $mahasiswa = MahasiswaModel::find($tugasKompen->id_mahasiswa);
    if (!$mahasiswa) {
        abort(404, 'Data mahasiswa tidak ditemukan');
    }

    $fileUrl = url('/storage/surat_berita_acara/surat_berita_acara_' . $mahasiswa->nim . '.pdf');

    $qrCode = QrCode::size(200)->generate($fileUrl);

    return view('mUpdateProgresTugasKompen.qr_code_view', compact('qrCode', 'fileUrl'));
}

}

