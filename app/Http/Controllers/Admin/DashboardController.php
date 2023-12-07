<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $admin = User::role('admin')->count();
        $manager = User::role('manager')->count();
        $kasir = User::role('kasir')->count();
        return view('admin.dashboard', compact('admin', 'manager', 'kasir'));
    }
}
