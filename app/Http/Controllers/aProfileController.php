<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class aProfileController extends Controller
{
    public function index()
    {
        $activeMenu = 'profile';
        $breadcrumb = (object) [
            'title' => 'Profile',
            'list' => ['Home', 'Profile']
        ];

        $user = Auth::guard('admin')->user();
        return view('aProfile.index', [
            'activeMenu' => $activeMenu,
            'breadcrumb' => $breadcrumb,
            'user' => $user
        ]);
    }

    public function edit_ajax()
    {
        $user = Auth::guard('admin')->user();
        return view('profile.edit_ajax', ['user' => $user]);
    }

    public function update_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $user = Auth::guard('admin')->user();

            $rules = [
                'username' => 'required|string|unique:m_admin,username,' . $user->id_admin . ',id_admin',
                'nama' => 'required|string|max:100',
                'password' => 'nullable|min:5|max:20'
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(),
                ]);
            }

            // Update basic info
            $user->username = $request->username;
            $user->nama = $request->nama;

            // // Handle avatar upload
            // if ($request->hasFile('avatar')) {
            //     // Delete old avatar if exists
            //     if ($user->avatar) {
            //         Storage::delete('public/avatars/' . $user->avatar);
            //     }

            //     // Store new avatar
            //     $avatarName = time() . '.' . $request->avatar->extension();
            //     $request->avatar->storeAs('public/avatars', $avatarName);
            //     $user->avatar = $avatarName;
            // }

            // Update password if provided
            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }

            $user->save();

            return response()->json([
                'status' => true,
                'message' => 'Profile berhasil diupdate'
            ]);
        }
        return redirect('/');
    }
}
