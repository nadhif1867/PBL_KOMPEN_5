<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class dWelcomeController extends Controller
{
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Dashboard',
            'list' => ['Home', 'Welcome']
        ];

        $activeMenu = 'dashboard';

        return view('d_welcome', ['breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu]);
    }
}
