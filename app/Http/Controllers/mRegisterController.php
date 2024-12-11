<?php

namespace App\Http\Controllers;

use App\Models\LevelModel;
use App\Models\MahasiswaModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class mRegisterController extends Controller
{
    public function registration()
    {
        $level = LevelModel::select('level_id', 'level_nama')->get();

        return view('auth.register')
            ->with('level', $level);
    }

    //Menyimpan data user baru
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username'  => 'required|string|min:3|unique:m_user,username',
            'nama'      => 'required|string|max:100',
            'password'  => 'required|min:5',
            'level_id'  => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal.',
                'msgField' => $validator->messages()
            ], 422);
        }

        MahasiswaModel::create([
            'username'  => $request->username,
            'nama'      => $request->nama,  // Pastikan 'nama' ada di sini
            'password'  => bcrypt($request->password),
            'level_id'  => $request->level_id
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Registrasi berhasil dilakukan!',
            'redirect' => url('/login')
        ]);
    }
}
