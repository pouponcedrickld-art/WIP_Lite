<?php

use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CampaignController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



///////////////////////Routes STEVEN ////////////////////////////////////////////////


Route::middleware(['auth', 'verified'])->group(function () {
    // Cette ligne génère automatiquement : campaigns.index, campaigns.store, campaigns.update, campaigns.destroy
    Route::resource('campaigns', CampaignController::class);
});
Route::middleware(['auth'])->group(function () {
    Route::get('/assignments', [AssignmentController::class, 'index'])->name('assignments.index');
    Route::post('/assignments', [AssignmentController::class, 'store'])->name('assignments.store');
    Route::delete('/assignments/{assignment}', [AssignmentController::class, 'release'])->name('assignments.release');
});







///////////////////////Routes MAXSON ////////////////////////////////////////////////









///////////////////////Routes OTHITHI ////////////////////////////////////////////////









///////////////////////Routes CEDRIC ////////////////////////////////////////////////









///////////////////////Routes DYLAN ////////////////////////////////////////////////











///////////////////////Routes ROGALEX ////////////////////////////////////////////////

require __DIR__.'/auth.php';
