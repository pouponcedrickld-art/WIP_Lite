<?php

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
});



///////////////////////Routes STEVEN ////////////////////////////////////////////////










///////////////////////Routes MAXSON ////////////////////////////////////////////////









///////////////////////Routes OTHITHI ////////////////////////////////////////////////









///////////////////////Routes CEDRIC ////////////////////////////////////////////////









///////////////////////Routes DYLAN ////////////////////////////////////////////////











///////////////////////Routes ROGALEX ////////////////////////////////////////////////


use App\Notifications\PlanningPublicated;
use App\Models\User;

Route::get('/test-notif', function () {
    $user = auth()->user(); // C'est toi
    $user->notify(new PlanningPublicated());
    return "Notification envoyée ! Retourne sur ton dashboard.";
});



Route::get('/admin/dashboard', function () {
    return Inertia::render('Dashboard/AdminDashboard'); // Le chemin vers ton fichier .vue
})->middleware(['auth'])->name('admin.dashboard');


Route::get('/notifications', function () {
    return Inertia::render('Notifications/Index', [
        'allNotifications' => auth()->user()->notifications // Récupère tout l'historique
    ]);
})->middleware(['auth']);


use App\Http\Controllers\DashboardController;

Route::get('/admin/dashboard', DashboardController::class)->middleware(['auth'])->name('admin.dashboard');


use App\Notifications\NewEmployeeAdded;


Route::get('/test-sidebar', function () {
    $user = auth()->user(); // L'utilisateur connecté (toi)
    
    // On envoie la notification à toi-même pour tester
    $user->notify(new NewEmployeeAdded("Marc-Antoine"));

    return back()->with('success', 'Notification créée !');
});




Route::get('/cp/dashboard', function () {
    return Inertia::render('CP/Dashboard', [
        // On envoie des données de test pour remplir tes composants
        'stats' => [
            'teams_count' => 12,
            'pending_plannings' => 4
        ],
        'my_teams' => [
            ['id' => 1, 'name' => 'Alice Martin', 'initials' => 'AM', 'campaign' => 'Project Alpha'],
            ['id' => 2, 'name' => 'Kevin Durand', 'initials' => 'KD', 'campaign' => 'Project Beta'],
            ['id' => 3, 'name' => 'Sara Ben', 'initials' => 'SB', 'campaign' => 'Project Alpha'],
        ]
    ]);
})->middleware(['auth'])->name('cp.dashboard');


require __DIR__.'/auth.php';
