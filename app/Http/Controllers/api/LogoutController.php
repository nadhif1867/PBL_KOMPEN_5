<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    public function logout(Request $request)
    {
        Auth::logout();

        // Return response JSON
        return response()->json([
            'success' => true,
            'message' => 'Logout Berhasil!',
        ]);
    }
}
