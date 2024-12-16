<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TugasAdminModel;
use App\Models\TugasDosenModel;
use App\Models\TugasTendikModel;
use Illuminate\Http\Request;

class TugasMahasiswaController extends Controller
{
    public function tugasSemua()
    {
        $tugasDosen = TugasDosenModel::with('pemberiTugas:username,id_dosen', 'bidangKompetensi:nama_bidkom,id_bidkom', 'jenisPenugasanDosen:jenis_kompen,id_jenis_kompen')->select('nama_tugas', 'deskripsi', 'status', 'tanggal_mulai', 'tanggal_selesai', 'jam_kompen', 'kuota', 'id_bidkom', 'id_jenis_kompen', 'id_dosen')->get();
        $tugasAdmin = TugasAdminModel::with('pemberiTugas:username,id_admin', 'bidangKompetensi:nama_bidkom,id_bidkom', 'jenisPenugasanAdmin:jenis_kompen,id_jenis_kompen')->select('nama_tugas', 'deskripsi', 'status', 'tanggal_mulai', 'tanggal_selesai', 'jam_kompen', 'kuota', 'id_bidkom', 'id_jenis_kompen', 'id_admin')->get();
        $tugasTendik = TugasTendikModel::with('pemberiTugas:username,id_tendik', 'bidangKompetensi:nama_bidkom,id_bidkom', 'jenisPenugasanTendik:jenis_kompen,id_jenis_kompen')->select('nama_tugas', 'deskripsi', 'status', 'tanggal_mulai', 'tanggal_selesai', 'jam_kompen', 'kuota', 'id_bidkom', 'id_jenis_kompen', 'id_tendik')->get();
        
        return response()->json([
            'tugas_dosen' => $tugasDosen,
            'tugas_admin' => $tugasAdmin,
            'tugas_tendik' => $tugasTendik
        ]);
    }
}
