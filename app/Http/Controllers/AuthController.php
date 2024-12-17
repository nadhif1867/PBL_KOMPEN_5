<?php

namespace App\Http\Controllers;

use App\Models\MahasiswaModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Tampilkan halaman login mahasiswa.
     */
    public function showMahasiswaLogin()
    {
        return view('auth.mLogin'); // Tampilan login khusus mahasiswa
    }

    /**
     * Proses login mahasiswa.
     */
    public function loginMahasiswa(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if (Auth::guard('mahasiswa')->attempt($request->only('username', 'password'))) {
            return redirect()->route('mahasiswa.dashboard');
        }

        return back()->withErrors(['loginError' => 'Username atau password salah.']);
    }


    /**
     * Tampilkan halaman registrasi mahasiswa.
     */
    public function showMahasiswaRegister()
    {
        return view('auth.Register'); // Halaman untuk form registrasi mahasiswa
    }

    /**
     * Proses registrasi mahasiswa.
     */
    public function registerMahasiswa(Request $request)
    {
        $validated = $request->validate([
            'username'     => 'required|string|min:3|max:50|unique:m_mahasiswa,username',
            'password'     => 'required|string|confirmed|min:5|max:50',
            'nama'         => 'required|string|max:100',
            'email'        => 'required|email|unique:m_mahasiswa,email|max:100',
            'kelas'        => 'required|string|min:3',
            'semester'     => 'required|string|min:5',
            'nim'          => 'required|numeric|digits:9|unique:m_mahasiswa,nim',
            'prodi'        => 'required|string|max:100',
            'tahun_masuk'  => 'required|numeric|min:1900|max:' . date('Y'),
            'no_telepon'   => 'required|numeric|digits_between:10,15',
            //'avatar'       => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Opsional
        ]);

        // Simpan data ke database
        MahasiswaModel::create([
            'id_level'     => 4, // Contoh ID default untuk mahasiswa
            'username'     => $validated['username'],
            'password'     => bcrypt($validated['password']),
            'nama'         => $validated['nama'],
            'email'        => $validated['email'],
            'nim'          => $validated['nim'],
            'prodi'        => $validated['prodi'],
            'tahun_masuk'  => $validated['tahun_masuk'],
            'no_telepon'   => $validated['no_telepon'],
            //'avatar'       => $request->file('avatar') ? $request->file('avatar')->store('avatars') : null,
        ]);


        return redirect()->route('register')->with('success', 'Registrasi berhasil. Silakan login.');
    }



    /**
     * Tampilkan halaman login admin.
     */
    public function showAdminLogin()
    {
        return view('auth.aLogin');
    }

    /**
     * Proses login admin.
     */
    public function loginAdmin(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('username', 'password');

        if (Auth::guard('admin')->attempt($credentials)) {
            return redirect()->route('admin.dashboard')->with('success', 'Berhasil login sebagai Admin!');
        }

        // Auth::logout();
        return back()->withErrors(['error' => 'Anda bukan admin!']);
    }



    /**
     * Tampilkan halaman login dosen.
     */
    public function showDosenLogin()
    {
        return view('auth.dLogin'); // Tampilan login khusus dosen/tendik
    }

    /**
     * Proses login dosen.
     */
    public function dosenLogin(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if (Auth::guard('dosen')->attempt($request->only('username', 'password'))) {
            return redirect()->route('dosen.dashboard');
        }

        return back()->withErrors(['loginError' => 'Username atau password salah.']);
    }


    /**
     * Tampilkan halaman login dosen/tendik.
     */
    public function showTendikLogin()
    {
        return view('auth.tLogin'); // Tampilan login khusus dosen/tendik
    }

    /**
     * Proses login dosen/tendik.
     */
    public function tendikLogin(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if (Auth::guard('tendik')->attempt($request->only('username', 'password'))) {
            return redirect()->route('tendik.dashboard');
        }

        return back()->withErrors(['loginError' => 'Username atau password salah.']);
    }
}
