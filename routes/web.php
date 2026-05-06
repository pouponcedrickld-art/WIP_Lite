<?php
use App\Http\Controllers\PlanningModelController;
use App\Http\Controllers\PlanningAssignmentController;
use App\Http\Controllers\ProfileController;
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






    ///////////////////////Routes CEDRIC ////////////////////////////////////////////////
    // --- Modèles de planning ---
    Route::resource('planning-models', PlanningModelController::class)->parameters(['planning-models' => 'planningModel']);

    // --- Affectations ---
    Route::resource('planning-assignments', PlanningAssignmentController::class)->parameters(['planning-assignments' => 'planningAssignment']);

    // --- Actions spéciales sur une affectation ---
    Route::patch('planning-assignments/{planningAssignment}/validate',[PlanningAssignmentController::class, 'validateAssignment'])->name('planning-assignments.validate');

    Route::patch('planning-assignments/{planningAssignment}/suspend',[PlanningAssignmentController::class, 'suspend'])->name('planning-assignments.suspend');

    Route::patch('planning-assignments/{planningAssignment}/terminate',[PlanningAssignmentController::class, 'terminate'])->name('planning-assignments.terminate');


    // --- Historique ---
    Route::get(
        'planning-assignments/{planningAssignment}/history',
        [PlanningAssignmentController::class, 'history']
    )->name('planning-assignments.history');
    


});



///////////////////////Routes STEVEN ////////////////////////////////////////////////






///////////////////////Routes MAXSON ////////////////////////////////////////////////









///////////////////////Routes OTHITHI ////////////////////////////////////////////////











///////////////////////Routes DYLAN ////////////////////////////////////////////////











///////////////////////Routes ROGALEX ////////////////////////////////////////////////

require __DIR__.'/auth.php';
