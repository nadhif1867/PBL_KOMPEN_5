<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\UserModel;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        // Validasi hanya untuk username dan password
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        // Cek apakah username ada di database
        $user = UserModel::where('username', $request->username)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['error' => 'Username atau password salah'], 401);
        }

        // Login sukses, return token atau data user
        return response()->json([
            'message' => 'Login berhasil',
            'user' => $user,
        ], 200); // Response sukses dengan status 200
    }
}
