<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\PlanningModelController;
use App\Http\Controllers\PlanningAssignmentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Cp\CpController;
use App\Http\Controllers\Sup\SupController;
use App\Http\Controllers\Tc\TcController;
use App\Models\User;
use App\Notifications\PlanningPublicated;
use App\Notifications\NewEmployeeAdded;
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
    Route::get('/tc/planning', [TcController::class, 'planning'])->name('tc.planning');
});


///////////////////////Routes OTHITHI ////////////////////////////////////////////////











///////////////////////Routes DYLAN ////////////////////////////////////////////////











///////////////////////Routes ROGALEX ////////////////////////////////////////////////

Route::get('/test-notif', function () {
    $user = auth()->user();
    $user->notify(new PlanningPublicated());
    return "Notification envoyée ! Retourne sur ton dashboard.";
});

Route::get('/test-sidebar', function () {
    $user = auth()->user();
    $user->notify(new NewEmployeeAdded("Marc-Antoine"));
    return back()->with('success', 'Notification créée !');
});




// Route::get('/cp/dashboard', function () {
//     return Inertia::render('CP/Dashboard', [
//         // On envoie des données de test pour remplir tes composants
//         'stats' => [
//             'teams_count' => 12,
//             'pending_plannings' => 4
//         ],
//         'my_teams' => [
//             ['id' => 1, 'name' => 'Alice Martin', 'initials' => 'AM', 'campaign' => 'Project Alpha'],
//             ['id' => 2, 'name' => 'Kevin Durand', 'initials' => 'KD', 'campaign' => 'Project Beta'],
//             ['id' => 3, 'name' => 'Sara Ben', 'initials' => 'SB', 'campaign' => 'Project Alpha'],
//         ]
//     ]);
// })->middleware(['auth'])->name('cp.dashboard');


require __DIR__.'/auth.php';
