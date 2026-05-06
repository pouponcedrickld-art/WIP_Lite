<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Models\Employee;
use App\Models\Position;
use App\Services\EmployeeService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Http\RedirectResponse;

class EmployeeController extends Controller
{
    protected EmployeeService $employeeService;

    public function __construct(EmployeeService $employeeService)
    {
        $this->employeeService = $employeeService;
    }

    /**
     * Afficher la liste des employés avec recherche et filtres
     */
    public function index(Request $request)
    {
        $query = Employee::with(['position', 'user']);

        // Recherche par terme
        if ($request->filled('search')) {
            $query->search($request->input('search'));
        }

        // Filtre par statut
        if ($request->filled('status')) {
            $query->byStatus($request->input('status'));
        }

        // Filtre par poste
        if ($request->filled('position_id')) {
            $query->byPosition($request->input('position_id'));
        }

        $employees = $query->orderBy('created_at', 'desc')->paginate(10);
        $positions = Position::all();

        return Inertia::render('Employees/Index', [
            'employees' => $employees,
            'positions' => $positions,
            'filters' => $request->only(['search', 'status', 'position_id']),
        ]);
    }

    /**
     * Afficher le formulaire de création
     */
    public function create()
    {
        $positions = Position::all();

        return Inertia::render('Employees/Create', [
            'positions' => $positions,
        ]);
    }

    /**
     * Enregistrer un nouvel employé
     */
    public function store(StoreEmployeeRequest $request): RedirectResponse
    {
        $employee = $this->employeeService->create($request->validated());

        return redirect()->route('employees.index')
            ->with('success', 'Employé créé avec succès');
    }

    /**
     * Afficher le formulaire d'édition
     */
    public function edit(Employee $employee)
    {
        $positions = Position::all();

        return Inertia::render('Employees/Edit', [
            'employee' => $employee->load(['position', 'user']),
            'positions' => $positions,
        ]);
    }

    /**
     * Mettre à jour un employé
     */
    public function update(UpdateEmployeeRequest $request, Employee $employee): RedirectResponse
    {
        $this->employeeService->update($employee, $request->validated());

        return redirect()->route('employees.index')
            ->with('success', 'Employé mis à jour avec succès');
    }

    /**
     * Afficher les détails d'un employé
     */
    public function show(Employee $employee)
    {
        return Inertia::render('Employees/Show', [
            'employee' => $employee->load(['position', 'user', 'assignments']),
        ]);
    }

    /**
     * Supprimer un employé (soft delete)
     */
    public function destroy(Employee $employee): RedirectResponse
    {
        $this->employeeService->delete($employee);

        return redirect()->route('employees.index')
            ->with('success', 'Employé supprimé avec succès');
    }

    /**
     * Changer le statut d'un employé
     */
    public function changeStatus(Request $request, Employee $employee): RedirectResponse
    {
        $request->validate([
            'status' => 'required|in:actif,inactif,suspendu',
        ]);

        $this->employeeService->changeStatus($employee, $request->input('status'));

        return redirect()->route('employees.index')
            ->with('success', 'Statut de l\'employé mis à jour avec succès');
    }

    /**
     * Afficher l'historique d'un employé
     */
    public function history(Employee $employee)
    {
        return Inertia::render('Employees/History', [
            'employee' => $employee->load(['position', 'user']),
            'history' => $employee->assignments()
                ->with(['manager', 'project'])
                ->orderBy('created_at', 'desc')
                ->get(),
        ]);
    }
}
