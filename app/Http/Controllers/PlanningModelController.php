<?php

namespace App\Http\Controllers;

use App\Models\PlanningModel;
use App\Http\Requests\StorePlanningModelRequest;
use App\Http\Requests\UpdatePlanningModelRequest;
use App\Http\Resources\PlanningModelResource;
use Inertia\Inertia;

class PlanningModelController extends Controller
{
    public function index()
    {
        $query = PlanningModel::with('creator');

        // Si l'utilisateur est CP, ne montrer que ses modèles
        if (auth()->user()->role->name === 'cp') {
            $query->where('created_by', auth()->id());
        }

        $models = $query->latest()->paginate(10);

        return Inertia::render('Planning/Models/Index', [
            'models' => PlanningModelResource::collection($models),
        ]);
    }

    public function create()
    {
        return Inertia::render('Planning/Models/Create');
    }

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

    public function show(PlanningModel $planningModel)
    {
        // Vérifier l'autorisation
        if (auth()->user()->role->name === 'cp' && $planningModel->created_by !== auth()->id()) {
            abort(403, 'Accès non autorisé.');
        }

        $planningModel->load('creator', 'assignments.employee');

        return Inertia::render('Planning/Models/Show', [
            'model' => (new PlanningModelResource($planningModel))->resolve(), // ✅
        ]);
    }

    public function edit(PlanningModel $planningModel)
    {
        // Vérifier l'autorisation
        if (auth()->user()->role->name === 'cp' && $planningModel->created_by !== auth()->id()) {
            abort(403, 'Accès non autorisé.');
        }

        return Inertia::render('Planning/Models/Edit', [
            'model' => (new PlanningModelResource($planningModel))->resolve(), // ✅
        ]);
    }
 
    public function update(UpdatePlanningModelRequest $request, PlanningModel $planningModel)
    {
        // Vérifier l'autorisation
        if (auth()->user()->role->name === 'cp' && $planningModel->created_by !== auth()->id()) {
            abort(403, 'Accès non autorisé.');
        }

        $planningModel->update($request->validated());

        return redirect()
            ->route('planning-models.index')
            ->with('success', 'Modèle de planning mis à jour avec succès.');
    }

    public function destroy(PlanningModel $planningModel)
    {
        // Vérifier l'autorisation
        if (auth()->user()->role->name === 'cp' && $planningModel->created_by !== auth()->id()) {
            abort(403, 'Accès non autorisé.');
        }

        // 1. Vérification logique : Existe-t-il n'importe quelle assignation liée ?
        if ($planningModel->assignments()->exists()) {
            return back()->with('error', 'Impossible de supprimer ce modèle car il est lié à des affectations existantes (historiques ou actives).');
        }

        try {
            $planningModel->delete();

            return redirect()
                ->route('planning-models.index')
                ->with('success', 'Modèle de planning supprimé avec succès.');

        } catch (\Illuminate\Database\QueryException $e) {
            // 2. Sécurité ultime : capture l'erreur SQL si la vérification ci-dessus échoue
            return back()->with('error', 'Erreur de base de données : suppression impossible car ce modèle est référencé ailleurs.');
        }
    }

}