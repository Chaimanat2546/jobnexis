<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard');
    }

    public function admin()
    {
        return view('admin.provider');
    }

    public function education()
    {
        return view('education.dashboard');
    }

    public function provider()
    {
        return view('provider.dashboard');
    }

    public function jobber()
    {
        return view('jobber.dashboard');
    }
}
