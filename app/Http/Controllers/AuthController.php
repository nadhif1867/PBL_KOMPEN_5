<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function adminLogin()
    {
        return view('auth.admin_login'); // Form login admin
    }

    public function adminAuthenticate(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        // Cari data admin berdasarkan username
        $admin = DB::table('m_admin')->where('username', $request->username)->first();

        if ($admin && Hash::check($request->password, $admin->password)) {
            // Simpan data admin ke session
            session(['user' => $admin, 'role' => 'admin']);
            return redirect()->route('a_welcome');
        }

        // Jika username/password salah
        return back()->withErrors(['loginError' => 'Username atau Password salah!']);
    }

    public function logout()
    {
        session()->flush();
        return redirect()->route('landing.index');
    }
}
