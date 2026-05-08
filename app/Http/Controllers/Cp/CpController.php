<?php

namespace App\Http\Controllers\Cp;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\Employee;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CpController extends Controller
{
    public function index()
    {
        // 🔥 récupérer l'employé du CP connecté
        $cpEmployee = Employee::where('user_id', auth()->id())->first();

        // ✅ Sécurité anti erreur 500
        if (!$cpEmployee) {
            abort(403, 'Aucun profil employé associé à cet utilisateur.');
        }

        // 1️⃣ Assignments du CP
        $assignments = Assignment::with(['employee', 'campaign'])
            ->where('manager_id', $cpEmployee->id)
            ->latest()
            ->get();

        // 2️⃣ Employés du CP
        $employees = Employee::whereHas('assignments', function ($q) use ($cpEmployee) {
            $q->where('manager_id', $cpEmployee->id);
        })->get();

        // 3️⃣ Plannings
        $plannings = Assignment::with(['campaign'])
            ->where('manager_id', $cpEmployee->id)
            ->whereHas('campaign', function ($q) {
                $q->whereNotNull('id');
            })
            ->get();

        return Inertia::render('Dashboard/CPDashboard', [
            'stats' => [
                'employees_count' => $employees->count(),
                'campaigns_count' => $assignments->pluck('campaign_id')->unique()->count(),
                'pending_count'   => $assignments->where('status', 'pending')->count(),
            ],

            'my_teams'   => $employees,
            'assignments'=> $assignments,
            'plannings'  => $plannings,
        ]);
    }
}