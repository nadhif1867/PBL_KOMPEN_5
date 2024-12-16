<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class mProfileController extends Controller
{
    public function index()
    {
        $activeMenu = 'profile';
        $breadcrumb = (object) [
            'title' => 'Account Setting',
            'list' => ['Home', 'Profile']
        ];

        $user = Auth::guard('mahasiswa')->user();
        return view('mProfile.index', [
            'activeMenu' => $activeMenu,
            'breadcrumb' => $breadcrumb,
            'user' => $user
        ]);
    }
}
