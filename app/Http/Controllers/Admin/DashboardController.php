<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    // SHOW DASHBOARD VIEW.
    public function index()
    {
        // ADMIN DASHBOARD VIEW
        return view('admin.dashboard');
    }
}
