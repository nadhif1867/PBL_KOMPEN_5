<?php

namespace App\Http\Controllers;

use App\Models\TugasAdminModel;
use App\Models\TugasDosenModel;
use App\Models\TugasKompenModel;
use App\Models\TugasTendikModel;
use App\Models\JenisKompenModel;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LihatPilihKompenController extends Controller
{
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Lihat dan Pilih Kompen',
            'list' => ['Home', 'Lihat dan Pilih Kompen']
        ];

        $page = (object)[
            'title' => 'Lihat dan Pilih Kompen'
        ];

        $activeMenu = 'mLihatPilihKompen';

        $tugasKompen = $this->getTugasReady();

        return view('mLihatPilihKompen.index', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu,
            'tugasKompen' => $tugasKompen
        ]);
    }

    public function getTugasReady()
    {

        $userId = auth('mahasiswa')->id();

        $existingApplications = TugasKompenModel::where('id_mahasiswa', $userId)->get();

        $tugas = collect();

        $tugasAdmin = TugasAdminModel::where('status', 'dibuka')->get();
        $tugasDosen = TugasDosenModel::where('status', 'dibuka')->get();
        $tugasTendik = TugasTendikModel::where('status', 'dibuka')->get();

        $tugas = $tugas->merge($tugasAdmin->map(function ($task) use ($existingApplications) {
            $existingApplication = $existingApplications->first(function ($app) use ($task) {
                return $app->id_tugas_admin == $task->id_tugas_admin;
            });
            $jenisKompen = JenisKompenModel::find($task->id_jenis_kompen);
            return (object)[
                'id_tugas_kompen' => 'admin_' . $task->id_tugas_admin,
                'pemberi_tugas' =>  $task->admin->nama ?? 'Unknown Admin',
                'jenis_tugas' => $jenisKompen ? $jenisKompen->jenis_kompen : 'Unknown Jenis Kompen',
                'nama_tugas' => $task->nama_tugas,
                'deskripsi' => $task->deskripsi,
                'status' => $task->status,
                'tanggal_mulai' => Carbon::parse($task->tanggal_mulai)->format('d-m-Y'),
                'tanggal_selesai' => Carbon::parse($task->tanggal_selesai)->format('d-m-Y'),
                'jam_kompen' => $task->jam_kompen,
                'kuota' => $task->kuota,
                'status_permintaan' => $existingApplication ? $existingApplication->status_penerimaan : null,
                'waktu_pengerjaan' => Carbon::parse($task->tanggal_mulai)->format('d-m-Y') . ' - ' . Carbon::parse($task->tanggal_selesai)->format('d-m-Y')
            ];
        }));

        $tugas = $tugas->merge($tugasDosen->map(function ($task) use ($existingApplications) {
            $existingApplication = $existingApplications->first(function ($app) use ($task) {
                return $app->id_tugas_dosen == $task->id_tugas_dosen;
            });
            $jenisKompen = JenisKompenModel::find($task->id_jenis_kompen);
            return (object)[
                'id_tugas_kompen' => 'dosen_' . $task->id_tugas_dosen,
                'pemberi_tugas' =>  $task->dosen->nama ?? 'Unknown Dosen',
                'jenis_tugas' => $jenisKompen ? $jenisKompen->jenis_kompen : 'Unknown Jenis Kompen',
                'nama_tugas' => $task->nama_tugas,
                'deskripsi' => $task->deskripsi,
                'status' => $task->status,
                'tanggal_mulai' => Carbon::parse($task->tanggal_mulai)->format('d-m-Y'),
                'tanggal_selesai' => Carbon::parse($task->tanggal_selesai)->format('d-m-Y'),
                'jam_kompen' => $task->jam_kompen,
                'kuota' => $task->kuota,
                'status_permintaan' => $existingApplication ? $existingApplication->status_penerimaan : null,
                'waktu_pengerjaan' => Carbon::parse($task->tanggal_mulai)->format('d-m-Y') . ' - ' . Carbon::parse($task->tanggal_selesai)->format('d-m-Y')
            ];
        }));
        $tugas = $tugas->merge($tugasTendik->map(function ($task) use ($existingApplications) {
            $existingApplication = $existingApplications->first(function ($app) use ($task) {
                return $app->id_tugas_tendik == $task->id_tugas_tendik;
            });
            $jenisKompen = JenisKompenModel::find($task->id_jenis_kompen);
            return (object)[
                'id_tugas_kompen' => 'tendik_' . $task->id_tugas_tendik,
                'pemberi_tugas' =>  $task->tendik->nama ?? 'Unknown Tendik',
                'jenis_tugas' => $jenisKompen ? $jenisKompen->jenis_kompen : 'Unknown Jenis Kompen',
                'nama_tugas' => $task->nama_tugas,
                'deskripsi' => $task->deskripsi,
                'status' => $task->status,
                'tanggal_mulai' => Carbon::parse($task->tanggal_mulai)->format('d-m-Y'),
                'tanggal_selesai' => Carbon::parse($task->tanggal_selesai)->format('d-m-Y'),
                'jam_kompen' => $task->jam_kompen,
                'kuota' => $task->kuota,
                'status_permintaan' => $existingApplication ? $existingApplication->status_penerimaan : null,
                'waktu_pengerjaan' => Carbon::parse($task->tanggal_mulai)->format('d-m-Y') . ' - ' . Carbon::parse($task->tanggal_selesai)->format('d-m-Y')
            ];
        }));
        return $tugas;
    }

    public function applyTugas($id)
    {
        $userId = auth('mahasiswa')->id();

        if (strpos($id, 'admin_') === 0) {
            $taskId = substr($id, 6); // Remove 'admin_' prefix
            $task = TugasAdminModel::find($taskId);

            $tugasKompen = new TugasKompenModel();
            $tugasKompen->id_tugas_admin = $taskId;

            $tugasKompen->id_mahasiswa = $userId;

            $tugasKompen->status_penerimaan = 'request';
            $tugasKompen->tanggal_apply = Carbon::now();
            $tugasKompen->save();

            return redirect()->route('lihatPilihKompen.index')->with('success', 'Permintaan tugas admin berhasil diajukan.');
        }

        if (strpos($id, 'dosen_') === 0) {
            $taskId = substr($id, 6); // Remove 'dosen_' prefix
            $task = TugasDosenModel::find($taskId);

            $tugasKompen = new TugasKompenModel();
            $tugasKompen->id_tugas_dosen = $taskId;
            $tugasKompen->id_mahasiswa = $userId;
            $tugasKompen->status_penerimaan = 'request';
            $tugasKompen->tanggal_apply = Carbon::now();
            $tugasKompen->save();

            return redirect()->route('lihatPilihKompen.index')->with('success', 'Permintaan tugas dosen berhasil diajukan.');
        }

        if (strpos($id, 'tendik_') === 0) {
            $taskId = substr($id, 7);
            $task = TugasTendikModel::find($taskId);

            $tugasKompen = new TugasKompenModel();
            $tugasKompen->id_tugas_tendik = $taskId;

            $tugasKompen->id_mahasiswa = $userId;
            $tugasKompen->status_penerimaan = 'request';
            $tugasKompen->tanggal_apply = Carbon::now();
            $tugasKompen->save();

            return redirect()->route('lihatPilihKompen.index')->with('success', 'Permintaan tugas tendik berhasil diajukan.');
        }

        return redirect()->route('lihatPilihKompen.index')->with('error', 'Tugas tidak ditemukan.');
    }
}
