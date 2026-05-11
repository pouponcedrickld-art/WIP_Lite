<?php

namespace App\Http\Controllers\Tc;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\Employee;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class TcController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // 1. Récupérer le profil employé du TC connecté
        $employee = Employee::where('user_id', $user->id)->firstOrFail();

        // 2. Récupérer l'affectation active (Campagne + Superviseur)
        // On suppose que dans ton modèle Assignment, la relation 'manager' pointe vers le Superviseur
        $assignment = Assignment::where('employee_id', $employee->id)
            ->where('status', 'active')
            ->with(['campaign', 'manager.user']) // On récupère la campagne et le manager (superviseur)
            ->first();

        // 3. Planning (Ici en statique comme dans ton exemple, ou à lier à une table Planning)
        $todaySchedule = [
            'morning_start' => '08:00',
            'morning_end' => '12:00',
            'lunch_break' => '12:00 - 13:00',
            'afternoon_start' => '13:00',
            'afternoon_end' => '17:00',
        ];

        return Inertia::render('Dashboard/TCDashboard', [
            'auth_employee' => [
                'full_name' => $employee->first_name . ' ' . $employee->last_name,
                'photo' => $employee->photo_url, // Si tu as ce champ
            ],
            'assignment' => $assignment ? [
                'campaign_name' => $assignment->campaign->name,
                'campaign_description' => $assignment->campaign->description,
                'manager_name' => $assignment->manager ? $assignment->manager->first_name . ' ' . $assignment->manager->last_name : 'Non assigné',
            ] : null,
            'today_schedule' => $todaySchedule,
            'my_stats' => [
                'quality_score' => 95,
                'off_days' => 12,
            ],
        ]);
    }

    public function planning()
    {
        // Tu peux rediriger vers l'index ou créer une vue spécifique
        return Inertia::render('Dashboard/TCPlanning');
    }
}