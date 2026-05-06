<?php

namespace App\Http\Controllers;

use App\Models\PlanningAssignment;
use App\Models\PlanningHistory;
use App\Models\Employee;
use App\Models\PlanningModel;
use App\Http\Requests\StorePlanningAssignmentRequest;
use App\Http\Requests\UpdatePlanningAssignmentRequest;
use App\Http\Resources\PlanningAssignmentResource;
use App\Http\Resources\PlanningHistoryResource;
use Inertia\Inertia;

class PlanningAssignmentController extends Controller
{
    // Liste toutes les affectations
    public function index()
    {
        $assignments = PlanningAssignment::with([
            'employee',
            'planningModel',
            'validator'
        ])
            ->latest()
            ->paginate(10);

        return Inertia::render('Planning/Assignments/Index', [
            'assignments' => PlanningAssignmentResource::collection($assignments),
        ]);
    }

    // Formulaire création
    public function create()
    {
        return Inertia::render('Planning/Assignments/Create', [
            'employees' => Employee::select('id', 'first_name', 'last_name', 'matricule')
                ->where('status', 'actif')
                ->get(),
            'planningModels' => PlanningModel::select('id', 'name', 'total_hours')->get(),
        ]);
    }

    // Enregistrer une affectation
    public function store(StorePlanningAssignmentRequest $request)
    {
        // Vérifier si l'employé a déjà un planning actif sur cette période
        $conflict = PlanningAssignment::where('employee_id', $request->employee_id)
            ->whereIn('status', ['en attente', 'validé'])
            ->where(function ($query) use ($request) {
                $query->whereBetween('start_date', [$request->start_date, $request->end_date ?? '9999-12-31'])
                    ->orWhereBetween('end_date', [$request->start_date, $request->end_date ?? '9999-12-31'])
                    ->orWhereNull('end_date');
            })
            ->exists();

        if ($conflict) {
            return back()->with('error', 'Cet employé a déjà un planning actif sur cette période.');
        }

        PlanningAssignment::create($request->validated());

        return redirect()
            ->route('planning-assignments.index')
            ->with('success', 'Affectation créée avec succès.');
    }

    // Détail d'une affectation

    public function show(PlanningAssignment $planningAssignment)
    {
        $planningAssignment->load([
            'employee',
            'planningModel',
            'validator',
        ]);

        return Inertia::render('Planning/Assignments/Show', [
            'assignment' => new PlanningAssignmentResource($planningAssignment),
            'histories' => [],
        ]);
    }

    // Formulaire édition
    public function edit(PlanningAssignment $planningAssignment)
    {
        return Inertia::render('Planning/Assignments/Edit', [
            'assignment' => new PlanningAssignmentResource($planningAssignment),
            'employees' => Employee::select('id', 'first_name', 'last_name', 'matricule')
                ->where('status', 'actif')
                ->get(),
            'planningModels' => PlanningModel::select('id', 'name', 'total_hours')->get(),
        ]);
    }

    // Mettre à jour une affectation
    public function update(UpdatePlanningAssignmentRequest $request, PlanningAssignment $planningAssignment)
    {
        // Bloquer la modification si déjà validé
        if ($planningAssignment->status === 'validé') {
            return back()->with('error', 'Impossible de modifier une affectation déjà validée.');
        }

        $planningAssignment->update($request->validated());

        return redirect()
            ->route('planning-assignments.index')
            ->with('success', 'Affectation mise à jour avec succès.');
    }

    // Supprimer une affectation
    public function destroy(PlanningAssignment $planningAssignment)
    {
        if ($planningAssignment->status === 'validé') {
            return back()->with('error', 'Impossible de supprimer une affectation validée.');
        }

        $planningAssignment->delete();

        return redirect()
            ->route('planning-assignments.index')
            ->with('success', 'Affectation supprimée avec succès.');
    }

    // -----------------------------------------------
    // ACTIONS SPÉCIALES
    // -----------------------------------------------

    // Valider une affectation
    public function validateAssignment(PlanningAssignment $assignment)
    {
        if ($assignment->status !== 'en attente') {
            return back()->with('error', 'Seules les affectations en attente peuvent être validées.');
        }

        $oldStatus = $assignment->status;

        $assignment->update([
            'status' => 'validé',
            'validated_by' => auth()->user()->employee->id,
            'validated_at' => now(),
        ]);

        // Historique
        PlanningHistory::create([
            'planning_assignment_id' => $assignment->id,
            'old_status' => $oldStatus,
            'new_status' => 'validé',
            'changed_by' => auth()->user()->id,
            'reason' => 'Validation de l\'affectation',
        ]);

        return back()->with('success', 'Affectation validée avec succès.');
    }

    // Suspendre une affectation
    public function suspend(PlanningAssignment $assignment)
    {
        if ($assignment->status !== 'validé') {
            return back()->with('error', 'Seules les affectations validées peuvent être suspendues.');
        }

        $oldStatus = $assignment->status;

        $assignment->update(['status' => 'suspendu']);

        // Historique
        PlanningHistory::create([
            'planning_assignment_id' => $assignment->id,
            'old_status' => $oldStatus,
            'new_status' => 'suspendu',
            'changed_by' => auth()->user()->id,
            'reason' => request('reason') ?? 'Suspension de l\'affectation',
        ]);

        return back()->with('success', 'Affectation suspendue avec succès.');
    }

    // Terminer une affectation
    public function terminate(PlanningAssignment $assignment)
    {
        if ($assignment->status === 'terminé') {
            return back()->with('error', 'Cette affectation est déjà terminée.');
        }

        $oldStatus = $assignment->status;

        $assignment->update([
            'status' => 'terminé',
            'end_date' => now()->toDateString(),
        ]);

        // Historique
        PlanningHistory::create([
            'planning_assignment_id' => $assignment->id,
            'old_status' => $oldStatus,
            'new_status' => 'terminé',
            'changed_by' => auth()->user()->id,
            'reason' => request('reason') ?? 'Fin de l\'affectation',
        ]);

        return back()->with('success', 'Affectation terminée avec succès.');
    }

    // Historique d'une affectation
    public function history(PlanningAssignment $assignment)
    {
        $histories = $assignment->histories()->with('user')->latest()->get();

        return Inertia::render('Planning/Assignments/History', [
            'assignment' => new PlanningAssignmentResource($assignment),
            'histories' => PlanningHistoryResource::collection($histories),
        ]);
    }
}