<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EmployeeController;
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
    
    
    

///////////////////////Routes STEVEN ////////////////////////////////////////////////










///////////////////////Routes MAXSON ////////////////////////////////////////////////









///////////////////////Routes OTHITHI ////////////////////////////////////////////////
// Routes pour la gestion des employés supprimés (trash/historique)
Route::get('/employees-trash', [EmployeeController::class, 'trash'])
    ->name('employees.trash');

// Routes pour restaurer et supprimer définitivement les employés supprimés
// Ces routes acceptent l'ID directement (pas de model binding)
Route::patch('/employees/{id}/restore', [EmployeeController::class, 'restore'])
    ->name('employees.restore');
Route::delete('/employees/{id}/force-delete', [EmployeeController::class, 'forceDelete'])
    ->name('employees.forceDelete');

// Routes pour la gestion des employés
Route::resource('employees', EmployeeController::class);
Route::patch('/employees/{employee}/status', [EmployeeController::class, 'changeStatus'])
    ->name('employees.changeStatus');
Route::get('/employees/{employee}/history', [EmployeeController::class, 'history'])
    ->name('employees.history');

// Route alternative avec dialogs (optionnel - utilise la même logique backend)
Route::get('/employees-dialog', [EmployeeController::class, 'index'])
    ->name('employees.indexDialog');
});









///////////////////////Routes CEDRIC ////////////////////////////////////////////////









///////////////////////Routes DYLAN ////////////////////////////////////////////////











///////////////////////Routes ROGALEX ////////////////////////////////////////////////

require __DIR__.'/auth.php';
