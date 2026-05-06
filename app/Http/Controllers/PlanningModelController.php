<?php

namespace App\Http\Controllers;

use App\Models\PlanningModel;
use App\Http\Requests\StorePlanningModelRequest;
use App\Http\Requests\UpdatePlanningModelRequest;
use App\Http\Resources\PlanningModelResource;
use Inertia\Inertia;

class PlanningModelController extends Controller
{
    // Liste tous les modèles
    public function index()
    {
        $models = PlanningModel::with('creator')
            ->latest()
            ->paginate(10);

        return Inertia::render('Planning/Models/Index', [
            'models' => PlanningModelResource::collection($models),
        ]);
    }

    // Formulaire création
    public function create()
    {
        return Inertia::render('Planning/Models/Create');
    }

    // Enregistrer un nouveau modèle
    public function store(StorePlanningModelRequest $request)
    {
        PlanningModel::create([
            ...$request->validated(),
            'created_by' => auth()->user()->id,
        ]);

        return redirect()
            ->route('planning-models.index')
            ->with('success', 'Modèle de planning créé avec succès.');
    }

    // Détail d'un modèle
    public function show(PlanningModel $planningModel)
    {
        $planningModel->load('creator', 'assignments.employee');

        return Inertia::render('Planning/Models/Show', [
            'model' => new PlanningModelResource($planningModel),
        ]);
    }

    // Formulaire édition
    public function edit(PlanningModel $planningModel)
    {
        return Inertia::render('Planning/Models/Edit', [
            'model' => new PlanningModelResource($planningModel),
        ]);
    }

    // Mettre à jour un modèle
    public function update(UpdatePlanningModelRequest $request, PlanningModel $planningModel)
    {
        $planningModel->update($request->validated());

        return redirect()
            ->route('planning-models.index')
            ->with('success', 'Modèle de planning mis à jour avec succès.');
    }

    // Supprimer un modèle
    public function destroy(PlanningModel $planningModel)
    {
        // Vérifier si le modèle est utilisé dans des affectations actives
        $hasActiveAssignments = $planningModel->assignments()
            ->whereIn('status', ['en attente', 'validé'])
            ->exists();

        if ($hasActiveAssignments) {
            return back()->with('error', 'Impossible de supprimer ce modèle, il est utilisé dans des affectations actives.');
        }

        $planningModel->delete();

        return redirect()
            ->route('planning-models.index')
            ->with('success', 'Modèle de planning supprimé avec succès.');
    }
}