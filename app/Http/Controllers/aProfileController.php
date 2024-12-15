<?php

namespace App\Http\Controllers;

use App\Models\AdminModel;
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
            'title' => 'Account Setting',
            'list' => ['Home', 'Profile']
        ];

        $user = Auth::guard('admin')->user();
        return view('aProfile.index', [
            'activeMenu' => $activeMenu,
            'breadcrumb' => $breadcrumb,
            'user' => $user
        ]);
    }

    // public function edit_ajax()
    // {
    //     $user = Auth::guard('admin')->user();
    //     return view('profile.edit_ajax', ['user' => $user]);
    // }

    // public function update_ajax(Request $request)
    // {
    //     if ($request->ajax() || $request->wantsJson()) {
    //         $user = Auth::guard('admin')->user();

    //         $rules = [
    //             'username' => 'required|string|unique:m_admin,username,' . $user->id_admin . ',id_admin',
    //             'nama' => 'required|string|max:100',
    //             'password' => 'nullable|min:5|max:20'
    //         ];

    //         $validator = Validator::make($request->all(), $rules);

    //         if ($validator->fails()) {
    //             return response()->json([
    //                 'status' => false,
    //                 'message' => 'Validasi Gagal',
    //                 'msgField' => $validator->errors(),
    //             ]);
    //         }

    //         // Update basic info
    //         $user->username = $request->username;
    //         $user->nama = $request->nama;



    //         // Update password if provided
    //         if ($request->filled('password')) {
    //             $user->password = Hash::make($request->password);
    //         }

    //         $user->save();

    //         return response()->json([
    //             'status' => true,
    //             'message' => 'Profile berhasil diupdate'
    //         ]);
    //     }
    //     return redirect('/');
    // }

    public function edit_ajax(Request $request)
    {
        $user = auth()->user(); // Mengambil user yang sedang login
        return view('aProfile.edit_ajax', compact('user'));
    }

    // public function update_ajax(Request $request)
    // {
    //     $user = auth()->user(); // Get the logged-in user

    //     // Validate the input
    //     $request->validate([
    //         'username' => 'required|string|max:50',
    //         'email' => 'required|email|max:100|unique:users,email,' . $user->id, // Ensure email uniqueness
    //         'no_telepon' => 'required|max:15',
    //         'address' => 'nullable|string|max:255',
    //     ]);

    //     try {
    //         // Update user data, including address if provided
    //         $user->update([
    //             'username' => $request->username,
    //             'email' => $request->email,
    //             'no_telepon' => $request->no_telepon,
    //             'address' => $request->address, // Make sure the address field is updated if available
    //         ]);

    //         return response()->json(['status' => true, 'message' => 'Profile updated successfully']);
    //     } catch (\Exception $e) {
    //         // Log the exception to help debug
    //         \Log::error('Error updating user profile: ' . $e->getMessage());

    //         return response()->json(['status' => false, 'message' => 'Failed to update profile']);
    //     }
    // }

    public function update_ajax(Request $request, $id)
    {
        // Cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
        } {
            $rules = [
                'username' => 'required|string|max:30|unique:m_admin,username',
                'password' => 'nullable|min:5',
                'nip' => 'required|string|min:3|unique:m_admin,nip',
                'no_telepon' => 'required|string|',
                'email' => 'required|string|',
                'nama' => 'required|string|max:100',
                'avatar' => 'nullable'
            ];

            // use Illuminate\Support\Facades\vaidator
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false, // response status, false: error/gagal, true: berhasil
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(),
                ]);
            }

            $check = AdminModel::find($id);
            if ($check) {
                $check->update($request->all());
                return response()->json([
                    'status' => true,
                    'message' => 'Data user berhasil diupdate'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }
        return redirect('/aManageKompen');
    }
}
