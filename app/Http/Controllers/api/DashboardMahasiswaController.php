<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AlphaModel;
use App\Models\MahasiswaModel;
use Illuminate\Http\Request;

class DashboardMahasiswaController extends Controller
{
    public function getDashboardMHS($id_mahasiswa)
    {
        if (!$id_mahasiswa) {
            return response()->json(['message' => 'Mahasiswa ID is required'], 400);
        }

        $mahasiswa = AlphaModel::where('id_mahasiswa', $id_mahasiswa)->first();

        if (!$mahasiswa) {
            return response()->json(['message' => 'Mahasiswa not found'], 404);
        }

        $jumlah_alpha = $mahasiswa->jumlah_alpha; // Ambil jumlah alpha
        $kompen_dibayar = $mahasiswa->kompen_dibayar; // Ambil jumlah kompen dibayar

        return response()->json([
            'id_mahasiswa' => $mahasiswa->id_mahasiswa,
            'jumlah_alpha' => $jumlah_alpha,
            'kompen_dibayar' => $kompen_dibayar,
        ]);
    }
}
