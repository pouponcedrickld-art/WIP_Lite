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
    public function index()
    {
        $user = auth()->user();
        $employee = $user->employee;

        // On prépare la requête avec les relations nécessaires
        $query = PlanningAssignment::with(['employee', 'planningModel', 'validator']);

        // --- LOGIQUE DE FILTRAGE SÉCURISÉE ---
        if ($user->role->name === 'admin') {
            // L'admin voit tout le monde
        } elseif ($user->role->name === 'cp') {
            // Le CP voit les plannings qu'il a validés 
            // OU ceux des employés qui lui sont rattachés via la table 'assignments'
            $query->where(function ($q) use ($employee) {
                $q->where('validated_by', $employee->id)
                    ->orWhereHas('employee.assignments', function ($sub) use ($employee) {
                        $sub->where('manager_id', $employee->id);
                    });
            });
        } elseif ($user->role->name === 'sup') {
            // Un Superviseur ne voit que les plannings des employés (TC) 
            // qui lui sont affectés comme manager
            $query->whereHas('employee.assignments', function ($q) use ($employee) {
                $q->where('manager_id', $employee->id);
            });
        } else {
            // Un TC (ou autre) ne voit que SON propre planning
            $query->where('employee_id', $employee ? $employee->id : 0);
        }

        $assignments = $query->latest()->paginate(10);

        return Inertia::render('Planning/Assignments/Index', [
            'assignments' => PlanningAssignmentResource::collection($assignments),
        ]);
    }

    public function create()
    {
        $user = auth()->user();
        $employee = $user->employee;

        // Si c'est un CP, il ne voit que les employés qui lui sont rattachés dans la table 'assignments'
        if ($user->role->name === 'cp') {
            $employeeIds = \App\Models\Assignment::where('manager_id', $employee->id)
                ->pluck('employee_id');

            $employees = Employee::whereIn('id', $employeeIds)
                ->where('status', 'actif')
                ->get(['id', 'first_name', 'last_name', 'matricule']);
        } else {
            // L'admin voit tout le monde
            $employees = Employee::where('status', 'actif')->get();
        }

        // Filtrer les modèles de planning selon le rôle
        $planningModelsQuery = PlanningModel::query();
        if ($user->role->name === 'cp') {
            $planningModelsQuery->where('created_by', $user->id);
        }
        $planningModels = $planningModelsQuery->get();

        return Inertia::render('Planning/Assignments/Create', [
            'employees' => $employees,
            'planningModels' => $planningModels,
        ]);
    }



    public function store(StorePlanningAssignmentRequest $request)
    {
        // Sécurité : Seuls Admin et CP peuvent créer
        if (!in_array(auth()->user()->role->name, ['admin', 'cp'])) {
            abort(403, 'Action non autorisée.');
        }

        $user = auth()->user();
        $employee = $user->employee;

        // Vérifier que le modèle appartient au CP s'il est CP
        if ($user->role->name === 'cp') {
            $model = PlanningModel::find($request->planning_model_id);
            if (!$model || $model->created_by !== $user->id) {
                abort(403, 'Modèle de planning non autorisé.');
            }

            // Vérifier que l'employé est sous sa responsabilité
            $canAssign = \App\Models\Assignment::where('employee_id', $request->employee_id)
                ->where('manager_id', $employee->id)
                ->exists();
            if (!$canAssign) {
                abort(403, 'Employé non autorisé pour cette affectation.');
            }
        }

        $conflict = PlanningAssignment::where('employee_id', $request->employee_id)
            ->whereIn('status', ['en attente', 'validé'])
            ->where(function ($query) use ($request) {
                $query->whereBetween('start_date', [$request->start_date, $request->end_date ?? '9999-12-31'])
                    ->orWhereBetween('end_date', [$request->start_date, $request->end_date ?? '9999-12-31'])
                    ->orWhereNull('end_date');
            })->exists();

        if ($conflict) {
            return back()->with('error', 'Cet employé a déjà un planning actif sur cette période.');
        }

        // Préparation des données
        $data = $request->validated();

        // Optionnel : Si l'admin ou le CP crée, on peut valider automatiquement
        $data['status'] = 'validé';
        $data['validated_by'] = auth()->user()->employee->id;
        $data['validated_at'] = now();

        PlanningAssignment::create($data);

        return redirect()
            ->route('planning-assignments.index')
            ->with('success', 'Affectation créée et validée avec succès.');
    }


    public function show(PlanningAssignment $planningAssignment)
    {
        $planningAssignment->load(['employee', 'planningModel', 'validator']);

        return Inertia::render('Planning/Assignments/Show', [
            'assignment' => (new PlanningAssignmentResource($planningAssignment))->resolve(),
            'histories' => [],
        ]);
    }

    public function edit(PlanningAssignment $planningAssignment)
    {
        $user = auth()->user();
        $employee = $user->employee;

        // Vérifier l'autorisation : CP ne peut éditer que ses affectations
        if ($user->role->name === 'cp') {
            $canEdit = $planningAssignment->validated_by === $employee->id ||
                \App\Models\Assignment::where('employee_id', $planningAssignment->employee_id)
                    ->where('manager_id', $employee->id)
                    ->exists();
            if (!$canEdit) {
                abort(403, 'Accès non autorisé.');
            }
        }

        $planningAssignment->load(['employee', 'planningModel', 'validator']);

        // Filtrer les employés et modèles selon le rôle
        $employeesQuery = Employee::select('id', 'first_name', 'last_name', 'matricule')->where('status', 'actif');
        $planningModelsQuery = PlanningModel::select('id', 'name', 'total_hours');

        if ($user->role->name === 'cp') {
            $employeeIds = \App\Models\Assignment::where('manager_id', $employee->id)->pluck('employee_id');
            $employeesQuery->whereIn('id', $employeeIds);
            $planningModelsQuery->where('created_by', $user->id);
        }

        return Inertia::render('Planning/Assignments/Edit', [
            'assignment' => (new PlanningAssignmentResource($planningAssignment))->resolve(),
            'employees' => $employeesQuery->get(),
            'planningModels' => $planningModelsQuery->get(),
        ]);
    }

    public function history(PlanningAssignment $planningAssignment)
    {
        $planningAssignment->load(['employee', 'planningModel', 'validator']);

        $histories = $planningAssignment->histories()->with('user')->latest()->get();

        return Inertia::render('Planning/Assignments/History', [
            'assignment' => (new PlanningAssignmentResource($planningAssignment))->resolve(),
            'histories' => PlanningHistoryResource::collection($histories)->resolve(),
        ]);
    }

    public function update(UpdatePlanningAssignmentRequest $request, PlanningAssignment $planningAssignment)
    {
        $user = auth()->user();
        $employee = $user->employee;

        // Vérifier l'autorisation
        if ($user->role->name === 'cp') {
            $canEdit = $planningAssignment->validated_by === $employee->id ||
                \App\Models\Assignment::where('employee_id', $planningAssignment->employee_id)
                    ->where('manager_id', $employee->id)
                    ->exists();
            if (!$canEdit) {
                abort(403, 'Accès non autorisé.');
            }

            // Vérifier que le modèle appartient au CP
            $model = PlanningModel::find($request->planning_model_id);
            if (!$model || $model->created_by !== $user->id) {
                abort(403, 'Modèle de planning non autorisé.');
            }
        }

        $planningAssignment->update($request->validated());

        return redirect()
            ->route('planning-assignments.index')
            ->with('success', 'Affectation mise à jour avec succès.');
    }


    public function destroy(PlanningAssignment $planningAssignment)
    {
        $user = auth()->user();
        $employee = $user->employee;

        // Sécurité : Seuls Admin et CP peuvent supprimer
        if (!in_array($user->role->name, ['admin', 'cp'])) {
            abort(403, 'Action non autorisée.');
        }

        // Vérifier l'autorisation pour CP
        if ($user->role->name === 'cp') {
            $canDelete = $planningAssignment->validated_by === $employee->id ||
                \App\Models\Assignment::where('employee_id', $planningAssignment->employee_id)
                    ->where('manager_id', $employee->id)
                    ->exists();
            if (!$canDelete) {
                abort(403, 'Accès non autorisé.');
            }
        }

        if ($planningAssignment->status === 'validé' && $user->role->name !== 'admin') {
            return back()->with('error', 'Seul un administrateur peut supprimer une affectation déjà validée.');
        }

        $planningAssignment->delete();

        return redirect()
            ->route('planning-assignments.index')
            ->with('success', 'Affectation supprimée avec succès.');
    }

    public function validateAssignment(PlanningAssignment $planningAssignment)
    {
        // Vérifier si l'utilisateur est bien le CP responsable ou un Admin
        $user = auth()->user();

        if ($user->role->name !== 'admin' && $user->role->name !== 'cp') {
            return back()->with('error', 'Vous n\'avez pas les droits pour valider ce planning.');
        }

        // Logic de validation...
        $planningAssignment->update([
            'status' => 'validé',
            'validated_by' => $user->employee->id,
            'validated_at' => now(),
        ]);

        return back()->with('success', 'Planning rendu effectif.');
    }

    public function suspend(PlanningAssignment $planningAssignment)
    {
        if ($planningAssignment->status !== 'validé') {
            return back()->with('error', 'Seules les affectations validées peuvent être suspendues.');
        }

        $oldStatus = $planningAssignment->status;

        $planningAssignment->update(['status' => 'suspendu']);

        PlanningHistory::create([
            'planning_assignment_id' => $planningAssignment->id,
            'old_status' => $oldStatus,
            'new_status' => 'suspendu',
            'changed_by' => auth()->user()->id,
            'reason' => request('reason') ?? "Suspension de l'affectation",
        ]);

        return back()->with('success', 'Affectation suspendue avec succès.');
    }

    public function terminate(PlanningAssignment $planningAssignment)
    {
        if ($planningAssignment->status === 'terminé') {
            return back()->with('error', 'Cette affectation est déjà terminée.');
        }

        $oldStatus = $planningAssignment->status;

        $planningAssignment->update([
            'status' => 'terminé',
            'end_date' => now()->toDateString(),
        ]);

        PlanningHistory::create([
            'planning_assignment_id' => $planningAssignment->id,
            'old_status' => $oldStatus,
            'new_status' => 'terminé',
            'changed_by' => auth()->user()->id,
            'reason' => request('reason') ?? "Fin de l'affectation",
        ]);

        return back()->with('success', 'Affectation terminée avec succès.');
    }
   
}