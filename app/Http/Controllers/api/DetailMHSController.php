<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UserModel;
use Illuminate\Http\Request;

class DetailMHSController extends Controller
{
    public function getUserProfile($id_mahasiswa)
    {
        // Validasi input ID
        if (!is_numeric($id_mahasiswa)) {
            return response()->json(['message' => 'Invalid ID format'], 400);
        }

        // Cek apakah user ditemukan
        $user = UserModel::find($id_mahasiswa);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        // Return data profil
        return response()->json([
            'username' => $user->username,
            'nama' => $user->nama,
            'nim' => $user->nim,
            'email'    => $user->email,
            'no_telepon'    => $user->no_telepon, // Gunakan kolom yang sesuai dengan database
            'password' => $user->password, // Sebaiknya hindari mengembalikan password
            'id_bidkom' => $user->id_bidkom, // Sebaiknya hindari mengembalikan password
        ]);
    }
}
