<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminController extends Controller
{

    public function index()
    {
        // dd('binin');
        return Inertia::render('Dashboard/AdminDashboard');
    }
}
