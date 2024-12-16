<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class dProfileController extends Controller
{
    public function index()
    {
        $activeMenu = 'profile';
        $breadcrumb = (object) [
            'title' => 'Account Setting',
            'list' => ['Home', 'Profile']
        ];

        $user = Auth::guard('dosen')->user();
        return view('dProfile.index', [
            'activeMenu' => $activeMenu,
            'breadcrumb' => $breadcrumb,
            'user' => $user
        ]);
    }
}
