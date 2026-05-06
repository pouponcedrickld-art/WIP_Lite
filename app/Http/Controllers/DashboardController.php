<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Employee;
use App\Models\Campaign;
use App\Models\Assignment;
use App\Models\User;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
       return Inertia::render('Dashboard/AdminDashboard', [
        'stats' => [
            'employees_count' => Employee::count(),
            'campaigns_count' => Campaign::where('status', 'active')->count(), // Ajuste selon tes colonnes
            'pending_count'   => Employee::whereDoesntHave('assignments')->count(), // Ceux qui n'ont pas de mission
            'alerts_count'    => Notification::count(), // Tu pourras lier ça à une logique d'erreurs plus tard
        ],
        'recent_assignments' => Assignment::with(['employee', 'campaign'])
            ->latest()
            ->take(5)
            ->get()
            ->map(fn($assign) => [
                'id' => $assign->id,
                'employee_name' => $assign->employee->first_name . ' ' . $assign->employee->last_name,
                'role' => $assign->employee->position->name ?? 'Non défini',
                'campaign_name' => $assign->campaign->name,
                'status' =>  $assign->employee->status, // Ou une logique de statut réelle
            ]),
    ]);
    }
}
