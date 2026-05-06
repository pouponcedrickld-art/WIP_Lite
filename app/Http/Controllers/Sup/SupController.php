<?php

namespace App\Http\Controllers\Sup;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SupController extends Controller
{
    public function index()
{
    return Inertia::render('Dashboard/SUPDashboard');
}
}
