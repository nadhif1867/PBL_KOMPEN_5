<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        if (Auth::guard('web') || Auth::guard('admin') || Auth::guard('dosen') || Auth::guard('tendik')->check()) {
            return redirect('/');
        }
        return view('auth.login');
    }

    public function postlogin(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $credentials = $request->only('username', 'password');

            if ($request->user_role == 'mahasiswa') {
                if (Auth::guard('web')->attempt($credentials)) {
                    return response()->json([
                        'status' => true,
                        'message' => 'Login Mahasiswa berhasil',
                        'redirect' => url('/')
                    ]);
                } else if (Auth::guard('admin')->attempt($credentials)) {
                    return response()->json([
                        'status' => true,
                        'message' => 'Login Admin Berhasil',
                        'redirect' => url('/')
                    ]);
                } else if (Auth::guard('dosen')->attempt($credentials)) {
                    return response()->json([
                        'status' => true,
                        'message' => 'Login Dosen Berhasil',
                        'redirect' => url('/')
                    ]);
                } else if (Auth::guard('tendik')->attempt($credentials)) {
                    return response()->json([
                        'status' => true,
                        'message' => 'Login Tendik Berhasil',
                        'redirect' => url('/')
                    ]);
                }
            }

            return response()->json([
                'status' => false,
                'message' => 'Login Gagal'
            ]);
        }
        return response('login');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('login');
    }
}
