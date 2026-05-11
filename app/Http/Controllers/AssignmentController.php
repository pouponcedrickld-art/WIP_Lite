<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\AssignmentHistory;
use App\Models\Employee;
use App\Models\Campaign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class AssignmentController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $userRole = $user->role->name ?? 'guest';

        // On ne récupère que les affectations ACTIVE dans l'arborescence
        $tree = Campaign::with(['assignments' => function($query) {
            $query->where('status', 'active')
                  ->with(['employee', 'manager']);
        }])->get();

        // On ne récupère que les employés qui ne sont PAS déjà affectés activement et qui sont ACTIFS
        $availableEmployees = Employee::where('status', 'actif')
            ->whereDoesntHave('assignments', function($query) {
                $query->where('status', 'active');
            })->get();

        $campaigns = Campaign::where('status', 'active')->get();

        // Redirection vers la vue spécifique selon le rôle
        $view = 'Assignments/Index'; // Par défaut (Admin)
        
        if ($userRole === 'cp') {
            $view = 'Assignments/CPIndex';
        } elseif ($userRole === 'sup') {
            $view = 'Assignments/SUPIndex';
        }

        return Inertia::render($view, [
            'campaignsTree' => $tree,
            'availableEmployees' => $availableEmployees,
            'campaigns' => $campaigns,
            'userRole' => $userRole,
            'isAdmin' => $userRole === 'admin'
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'campaign_id' => 'required|exists:campaigns,id',
            'manager_id'  => 'nullable|exists:employees,id',
            'position_id' => 'required|integer', // 1: CP, 2: SUP, 3: TC
            'reason'      => 'nullable|string'
        ]);

        DB::transaction(function () use ($validated) {
            // 1. Création de l'affectation
            $assignment = Assignment::create([
                'employee_id' => $validated['employee_id'],
                'campaign_id' => $validated['campaign_id'],
                'manager_id'  => $validated['manager_id'],
                'position_id' => $validated['position_id'],
                'status'      => 'active',
                'start_date'  => now(),
            ]);

            // 2. Historisation
            AssignmentHistory::create([
                'assignment_id'   => $assignment->id,
                'employee_id'     => $validated['employee_id'],
                'new_manager_id'  => $validated['manager_id'],
                'new_campaign_id' => $validated['campaign_id'],
                'action_type'     => 'assign',
                'changed_by'      => auth()->id(),
                'reason'          => $validated['reason'] ?? 'Nouvelle affectation',
            ]);

            // 3. Update Statut Employé
            Employee::where('id', $validated['employee_id'])->update(['status' => 'actif']);
        });

        return redirect()->back()->with('success', 'Affectation réussie.');
    }

public function release(Assignment $assignment)
{
    DB::transaction(function () use ($assignment) {
        // 1. Historisation (Indispensable pour garder une trace dans assignment_historys)
        AssignmentHistory::create([
            'assignment_id'   => $assignment->id,
            'employee_id'     => $assignment->employee_id,
            'action_type'     => 'release',
            'changed_by'      => auth()->id(),
            'reason'          => 'Désaffectation manuelle'
        ]);

        // 2. On change le statut de l'affectation
        // Elle reste en base pour l'historique, mais disparaît du plateau (index)
        $assignment->update([
            'status' => 'suspendu', 
            'end_date' => now()
        ]);
    });

    return redirect()->back()->with('success', 'Ressource libérée avec succès.');
}
}
