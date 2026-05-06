<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Cp\CpController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Sup\SupController;
use App\Http\Controllers\Tc\TcController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    // if (Auth::check()) {
    //     $user = Auth::user();

    //     return match ($user->role->name) {
    //         'admin' => redirect()->route('admin.dashboard'),
    //         'cp' => redirect()->route('cp.dashboard'),
    //         'sup' => redirect()->route('sup.dashboard'),
    //         'tc' => redirect()->route('tc.dashboard'),
    //         default => abort(403),
    //     };
    // }

    return Inertia::render('Auth/Login', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

// Route::get('/dashboard', function () {
//     return Inertia::render('Dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



///////////////////////Routes STEVEN ////////////////////////////////////////////////










///////////////////////Routes MAXSON ////////////////////////////////////////////////

Route::middleware(['auth', 'admin'])->group(function () {

    Route::get('/admin/dashboard', [AdminController::class, 'index'])
        ->name('admin.dashboard');
});

Route::middleware(['auth', 'cp'])->group(function () {

    Route::get('/cp/dashboard', [CpController::class, 'index'])
        ->name('cp.dashboard');
});

Route::middleware(['auth', 'sup'])->group(function () {

    Route::get('/sup/dashboard', [SupController::class, 'index'])
        ->name('sup.dashboard');
});

Route::middleware(['auth','tc'])->group(function () {

    Route::get('/tc/dashboard', [TcController::class, 'index'])
        ->name('tc.dashboard');
});







///////////////////////Routes OTHITHI ////////////////////////////////////////////////









///////////////////////Routes CEDRIC ////////////////////////////////////////////////









///////////////////////Routes DYLAN ////////////////////////////////////////////////











///////////////////////Routes ROGALEX ////////////////////////////////////////////////

require __DIR__ . '/auth.php';
