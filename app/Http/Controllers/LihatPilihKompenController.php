<?php

namespace App\Http\Controllers;

use App\Models\TugasAdminModel;
use App\Models\TugasDosenModel;
use App\Models\TugasKompenModel;
use App\Models\TugasTendikModel;
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

        // Ambil semua tugas kompen yang siap untuk diakses mahasiswa
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
        // Get the currently logged-in user's ID
        // $userId = auth()->user()->id;
        //paksa hardcoded
        $userId = 4;

        // Get existing applications for the current user
        $existingApplications = TugasKompenModel::where('id_mahasiswa', $userId)->get();

        $tugas = collect();

        // Combine tasks from admin, dosen, and tendik
        $tugasAdmin = TugasAdminModel::where('status', 'dibuka')->get();
        $tugasDosen = TugasDosenModel::where('status', 'dibuka')->get();
        $tugasTendik = TugasTendikModel::where('status', 'dibuka')->get();

        // Process admin tasks
        $tugas = $tugas->merge($tugasAdmin->map(function ($task) use ($existingApplications) {
            // Check if this task has been applied to already
            $existingApplication = $existingApplications->first(function ($app) use ($task) {
                return $app->id_tugas_admin == $task->id_tugas_admin;
            });

            return (object)[
                'id_tugas_kompen' => 'admin_' . $task->id_tugas_admin,
                'pemberi_tugas' =>  $task->admin->nama ?? 'Unknown Admin',
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

        // Similar processing for dosen tasks
        $tugas = $tugas->merge($tugasDosen->map(function ($task) use ($existingApplications) {
            $existingApplication = $existingApplications->first(function ($app) use ($task) {
                return $app->id_tugas_dosen == $task->id_tugas_dosen;
            });

            return (object)[
                'id_tugas_kompen' => 'dosen_' . $task->id_tugas_dosen,
                'pemberi_tugas' =>  $task->dosen->nama ?? 'Unknown Dosen',
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

        // Similar processing for tendik tasks
        $tugas = $tugas->merge($tugasTendik->map(function ($task) use ($existingApplications) {
            $existingApplication = $existingApplications->first(function ($app) use ($task) {
                return $app->id_tugas_tendik == $task->id_tugas_tendik;
            });

            return (object)[
                'id_tugas_kompen' => 'tendik_' . $task->id_tugas_tendik,
                'pemberi_tugas' =>  $task->tendik->nama ?? 'Unknown Tendik',
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
        // Logic for Admin tasks
        if (strpos($id, 'admin_') === 0) {
            $taskId = substr($id, 6); // Remove 'admin_' prefix
            $task = TugasAdminModel::find($taskId);

            $tugasKompen = new TugasKompenModel();
            $tugasKompen->id_tugas_admin = $taskId;
            $tugasKompen->id_mahasiswa = 4;
            // $tugasKompen->id_mahasiswa = auth()->user()->id;
            $tugasKompen->status_penerimaan = 'request';
            $tugasKompen->tanggal_apply = Carbon::now();
            $tugasKompen->save();

            return redirect()->route('lihatPilihKompen.index')->with('success', 'Permintaan tugas admin berhasil diajukan.');
        }

        // Logic for Dosen tasks
        if (strpos($id, 'dosen_') === 0) {
            $taskId = substr($id, 6); // Remove 'dosen_' prefix
            $task = TugasDosenModel::find($taskId);

            $tugasKompen = new TugasKompenModel();
            $tugasKompen->id_tugas_dosen = $taskId;
            $tugasKompen->id_mahasiswa = 4;
            // $tugasKompen->id_mahasiswa = auth()->user()->id;
            $tugasKompen->status_penerimaan = 'request';
            $tugasKompen->tanggal_apply = Carbon::now();
            $tugasKompen->save();

            return redirect()->route('lihatPilihKompen.index')->with('success', 'Permintaan tugas dosen berhasil diajukan.');
        }

        // Logic for Tendik tasks
        if (strpos($id, 'tendik_') === 0) {
            $taskId = substr($id, 7); // Remove 'tendik_' prefix
            $task = TugasTendikModel::find($taskId);

            $tugasKompen = new TugasKompenModel();
            $tugasKompen->id_tugas_tendik = $taskId;
            $tugasKompen->id_mahasiswa = 4;
            // $tugasKompen->id_mahasiswa = auth()->user()->id;
            $tugasKompen->status_penerimaan = 'request';
            $tugasKompen->tanggal_apply = Carbon::now();
            $tugasKompen->save();

            return redirect()->route('lihatPilihKompen.index')->with('success', 'Permintaan tugas tendik berhasil diajukan.');
        }

        // If no matching task type is found
        return redirect()->route('lihatPilihKompen.index')->with('error', 'Tugas tidak ditemukan.');
    }
}
