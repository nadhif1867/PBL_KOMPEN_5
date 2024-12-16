<?php

namespace App\Http\Controllers\Api;

use App\Models\UserModel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'username' => 'required|unique:m_mahasiswa,username', // Validasi username harus unik
            'nama' => 'required|string|max:255',
            'password' => 'required|string|min:5|confirmed',
            'nim' => 'required|integer|unique:m_mahasiswa,nim',
            'prodi' => 'required|string|max:50',
            'email' => 'required|email|max:100|unique:m_mahasiswa,email',
            'tahun_masuk' => 'required|integer',
            'no_telepon' => 'required|string|max:15',
            'avatar' => 'nullable|file|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Jika validasi gagal
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Handle file upload
        $avatarName = null;
        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $avatarName = time() . '_' . $avatar->getClientOriginalName();
            $avatar->storeAs('public/avatars', $avatarName); // Simpan file di folder storage/app/public/avatars
        }

        // Buat user baru dengan id_level = 4
        $user = UserModel::create([
            'username' => $request->username,
            'nama' => $request->nama,
            'password' => bcrypt($request->password), // Hash password
            'id_level' => 4, // langsung id_level = 4
            'nim' => $request->nim,
            'prodi' => $request->prodi,
            'email' => $request->email,
            'tahun_masuk' => $request->tahun_masuk,
            'no_telepon' => $request->no_telepon,
            'avatar' => $avatarName,
        ]);

        // Jika user berhasil dibuat
        if ($user) {
            return response()->json([
                'success' => true,
                'user' => $user,
            ], 201);
        }

        // Jika proses gagal
        return response()->json([
            'success' => false,
            'message' => 'Gagal membuat user.',
        ], 409);
    }
}
