<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Cp\CpController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Sup\SupController;
use App\Http\Controllers\Tc\TcController;
use App\Http\Controllers\EmployeeController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


Route::get('/', function () {
    if (!auth()->check()) {
        return redirect()->route('login');
    }

    $user = auth()->user();

    $route = match ($user->role->name) {
        'admin' => 'admin.dashboard',
        'cp' => 'cp.dashboard',
        'sup' => 'sup.dashboard',
        'tc' => 'tc.dashboard',
        default => abort(403),
    };

    return redirect()->route($route);
});


// 2. Routes accessibles uniquement aux invités (non-connectés)
Route::middleware('guest')->group(function () {
    Route::get('/login', function () {
        return Inertia::render('Auth/Login', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
        ]);
    })->name('login');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    
    

///////////////////////Routes STEVEN ////////////////////////////////////////////////










///////////////////////Routes MAXSON ////////////////////////////////////////////////

Route::middleware(['auth', 'admin'])->group(function () {

    Route::get('/admin/dashboard', [AdminController::class, 'index'])
        ->name('admin.dashboard');

    Route::post('/admin/no_users', [AdminController::class, 'no_users'])->name('no_users');
});

Route::middleware(['auth', 'cp'])->group(function () {

    Route::get('/cp/dashboard', [CpController::class, 'index'])
        ->name('cp.dashboard');
});

Route::middleware(['auth', 'sup'])->group(function () {

    Route::get('/sup/dashboard', [SupController::class, 'index'])
        ->name('sup.dashboard');
});

Route::middleware(['auth', 'tc'])->group(function () {

    Route::get('/tc/dashboard', [TcController::class, 'index'])
        ->name('tc.dashboard');
});







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


use App\Notifications\PlanningPublicated;
use App\Models\User;

Route::get('/test-notif', function () {
    $user = auth()->user(); // C'est toi
    $user->notify(new PlanningPublicated());
    return "Notification envoyée ! Retourne sur ton dashboard.";
});



// Route::get('/admin/dashboard', function () {
//     return Inertia::render('Dashboard/AdminDashboard'); // Le chemin vers ton fichier .vue
// })->middleware(['auth'])->name('admin.dashboard');


// Route::get('/notifications', function () {
//     return Inertia::render('Notifications/Index', [
//         'allNotifications' => auth()->user()->notifications // Récupère tout l'historique
//     ]);
// })->middleware(['auth']);


use App\Http\Controllers\DashboardController;

// Route::get('/admin/dashboard', DashboardController::class)->middleware(['auth'])->name('admin.dashboard');


use App\Notifications\NewEmployeeAdded;


Route::get('/test-sidebar', function () {
    $user = auth()->user(); // L'utilisateur connecté (toi)

    // On envoie la notification à toi-même pour tester
    $user->notify(new NewEmployeeAdded("Marc-Antoine"));

    return back()->with('success', 'Notification créée !');
});




use App\Http\Controllers\ReportingController;

Route::middleware(['auth'])->group(function () {
    // Route pour voir la liste des rapports
    Route::get('/reporting', [ReportingController::class, 'index'])->name('reporting.index');
    
    // Route pour afficher le formulaire de création (si tu ne fais pas de modal)
    Route::get('/reporting/create', [ReportingController::class, 'create'])->name('reporting.create');
    
    // Route pour enregistrer un nouveau rapport
    Route::post('/reporting', [ReportingController::class, 'store'])->name('reporting.store');
});


require __DIR__ . '/auth.php';
