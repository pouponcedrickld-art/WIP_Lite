<?php

namespace App\Http\Controllers\Tc;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TcController extends Controller
{
    public function index()
    {
        
        return Inertia::render('Dashboard/TCDashboard');
    }
}
