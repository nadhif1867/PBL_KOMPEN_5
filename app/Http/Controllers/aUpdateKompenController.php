<?php

namespace App\Http\Controllers;

use App\Models\RiwayatKompenModel;
use App\Models\TugasKompenModel;
use App\Models\AlphaModel;
use App\Models\ProgresTugasModel;
use Illuminate\Support\Facades\Log;


use Illuminate\Http\Request;

class aUpdateKompenController extends Controller
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

        $activeMenu = 'aUpdateKompen';

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

        return view('aUpdateKompen.index', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu,
            'data' => $data
        ]);
    }

    // public function TugasSelesai($idProgres)
    // {
    //     try {
    //         $progresTugas = ProgresTugasModel::findOrFail($idProgres);
    //         $progresTugas->status_progres = 'selesai';
    //         $progresTugas->save();

    //         return redirect()->back()->with('success', 'Status progres berhasil diubah menjadi selesai.');
    //     } catch (\Exception $e) {
    //         return redirect()->back()->with('error', 'Gagal mengubah status progres: ' . $e->getMessage());
    //     }
    // }

    public function updateTugasSelesai($idProgres, Request $request)
    {
        try {
            $progresTugas = ProgresTugasModel::findOrFail($idProgres);
            $progresTugas->status_progres = 'selesai';
            $progresTugas->save();

            return response()->json([
                'success' => true,
                'message' => 'Status progres berhasil diubah menjadi selesai.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengubah status progres: ' . $e->getMessage()
            ]);
        }
    }

    public function KompenDiterima($idRiwayat)
    {
        try {
            // Temukan riwayat kompen
            $riwayat = RiwayatKompenModel::findOrFail($idRiwayat);

            // Temukan tugas kompen terkait
            $tugasKompen = TugasKompenModel::findOrFail($riwayat->id_tugas_kompen);

            // Hitung jam kompen
            $jamKompen = 0;
            if ($tugasKompen->id_tugas_admin) {
                $jamKompen = $tugasKompen->tugasAdmin->jam_kompen ?? 0;
            } elseif ($tugasKompen->id_tugas_dosen) {
                $jamKompen = $tugasKompen->tugasDosen->jam_kompen ?? 0;
            } elseif ($tugasKompen->id_tugas_tendik) {
                $jamKompen = $tugasKompen->tugasTendik->jam_kompen ?? 0;
            }

            // Cari data alpha mahasiswa
            $alpha = AlphaModel::where('id_mahasiswa', $tugasKompen->id_mahasiswa)->first();

            if (!$alpha) {
                Log::error("Alpha data not found for mahasiswa ID: " . $tugasKompen->id_mahasiswa);
                return redirect()->back()->with('error', 'Data alpha tidak ditemukan.');
            }

            // Log sebelum perubahan
            Log::info("Mahasiswa ID: " . $tugasKompen->id_mahasiswa);
            Log::info("Jam Kompen: $jamKompen");
            Log::info("Jumlah Alpha Sebelum: " . $alpha->jumlah_alpha);
            Log::info("Kompen Dibayar Sebelum: " . $alpha->kompen_dibayar);

            // Kurangi jumlah alpha dan tambah kompen dibayar
            $alpha->jumlah_alpha = max(0, $alpha->jumlah_alpha - $jamKompen);
            $alpha->kompen_dibayar += $jamKompen;
            $alpha->save();

            // Ubah status riwayat kompen menjadi diterima
            $riwayat->status = 'diterima';
            $riwayat->save();

            // Log setelah perubahan
            Log::info("Jumlah Alpha Sesudah: " . $alpha->jumlah_alpha);
            Log::info("Kompen Dibayar Sesudah: " . $alpha->kompen_dibayar);

            return redirect()->back()->with('success', 'Kompen berhasil diterima dan jumlah alpha dikurangi.');
        } catch (\Exception $e) {
            Log::error('Error in KompenDiterima: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal menerima kompen: ' . $e->getMessage());
        }
    }

    // public function kompenSelesai($idRiwayat, Request $request)
    // {
    //     try {
    //         $riwayat = RiwayatKompenModel::findOrFail($idRiwayat);

    //         $tugasKompen = TugasKompenModel::findOrFail($riwayat->id_tugas_kompen);

    //         $jamKompen = 0;
    //         if ($tugasKompen->id_tugas_admin) {
    //             $jamKompen = $tugasKompen->tugasAdmin->jam_kompen ?? 0;
    //         } elseif ($tugasKompen->id_tugas_dosen) {
    //             $jamKompen = $tugasKompen->tugasDosen->jam_kompen ?? 0;
    //         } elseif ($tugasKompen->id_tugas_tendik) {
    //             $jamKompen = $tugasKompen->tugasTendik->jam_kompen ?? 0;
    //         }

    //         Log::info("Jam Kompen: $jamKompen");

    //         $alpha = AlphaModel::where('id_mahasiswa', $tugasKompen->id_mahasiswa)->first();

    //         if (!$alpha) {
    //             Log::error("Alpha data not found for mahasiswa ID: " . $tugasKompen->id_mahasiswa);
    //             return redirect()->back()->with('error', 'Data alpha tidak ditemukan.');
    //         }

    //         Log::info("Jumlah Alpha Sebelum: " . $alpha->jumlah_alpha);
    //         Log::info("Kompen Dibayar Sebelum: " . $alpha->kompen_dibayar);

    //         $alpha->jumlah_alpha = max(0, $alpha->jumlah_alpha - $jamKompen);
    //         $alpha->kompen_dibayar += $jamKompen;

    //         $alpha->save();

    //         Log::info("Jumlah Alpha Sesudah: " . $alpha->jumlah_alpha);
    //         Log::info("Kompen Dibayar Sesudah: " . $alpha->kompen_dibayar);

    //         $riwayat->status = 'selesai';
    //         $riwayat->save();

    //         return redirect()->back()->with('success', 'Kompen selesai dan jumlah alpha berhasil dikurangi.');
    //     } catch (\Exception $e) {
    //         Log::error('Error: ' . $e->getMessage());
    //         return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
    //     }
    // }
}
