<?php

namespace App\Http\Controllers\Cp;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CpController extends Controller
{
    public function index()
{
    return Inertia::render('Dashboard/CPDashboard');
}
}
