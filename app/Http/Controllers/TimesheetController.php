<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Timesheet;
use App\Models\TimesheetEntry;
use App\Models\TimesheetHistory;
use App\Models\PlanningAssignment;
use App\Models\PlanningModel;
use App\Models\Assignment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class TimesheetController extends Controller
{
public function index(Request $request)
{
    $user = Auth::user();
    $week = $request->get('week', now()->format('Y-\WW'));
    $formattedWeek = (strpos($week, 'W') === false) ? str_replace('-', '-W', $week) : $week;

    try {
        $startDate = Carbon::parse($formattedWeek)->startOfWeek();
    } catch (\Exception $e) {
        $startDate = Carbon::now()->startOfWeek();
    }
    $endDate = $startDate->copy()->endOfWeek();

    $role = $user->role->name;
    $query = Employee::query();

    // Logique de filtrage selon le rôle
    if ($role === 'sup') {
        $query->whereHas('assignments', function($q) use ($user) {
            $q->where('manager_id', $user->employee->id)->where('status', 'actif');
        })->whereHas('position', function($q) {
            $q->where('code', 'TC');
        });
    } elseif ($role === 'cp') {
        $query->whereHas('assignments', function($q) use ($user) {
            $q->where('manager_id', $user->employee->id)->where('status', 'actif');
        })->whereHas('position', function($q) {
            $q->where('code', 'SUP');
        });
    }

    // Récupération des subordonnés
    $subordinates = ($role === 'tc') ? collect() : $query->with(['position'])->get();

    // AJOUT DE SOI-MÊME : On récupère l'employé connecté
    $self = $user->employee->load('position');
    
    // On fusionne : Soi-même d'abord, puis les subordonnés
    $employees = collect([$self])->concat($subordinates);

    // Charger les timesheets et les heures de planning (votre logique existante)
    $employees->each(function($employee) use ($startDate, $endDate) {
        $timesheet = Timesheet::where('employee_id', $employee->id)
            ->where('period_start', $startDate->format('Y-m-d'))
            ->where('period_end', $endDate->format('Y-m-d'))
            ->with('entries')
            ->first();

        $employee->timesheet_for_period = $timesheet;
        
        $planningAssignment = PlanningAssignment::where('employee_id', $employee->id)
            ->where('start_date', '<=', $startDate)
            ->where('end_date', '>=', $endDate)
            ->where('status', 'validé')
            ->with('planningModel')
            ->first();
            
        $planningHours = [];
        if ($planningAssignment) {
            $model = $planningAssignment->planningModel;
            $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
            foreach ($days as $index => $day) {
                $date = $startDate->copy()->addDays($index);
                $planningHours[$date->format('Y-m-d')] = $model->{$day . '_hours'};
            }
        }
        $employee->planning_hours = $planningHours;
    });

    return Inertia::render('Timesheets/Index', [
        'employees' => $employees,
        'auth_employee_id' => $user->employee->id, // On passe l'ID pour le comparer en Vue
        'startDate' => $startDate->format('Y-m-d'),
        'endDate' => $endDate->format('Y-m-d'),
        'role' => $role,
        'currentWeek' => $week,
    ]);
}
    
    public function show(Employee $employee, Request $request)
    {
        $user = Auth::user();
        $this->authorizeAccess($user, $employee);
        
        $week = $request->get('week', now()->format('Y-\WW'));
        $year = (int)substr($week, 0, 4);
        $weekNumber = (int)substr($week, 6); // Corrigé: commencer à l'index 6 pour sauter "Y-W"
        
        $startDate = Carbon::now()->setISODate($year, $weekNumber)->startOfWeek();
        $endDate = $startDate->copy()->endOfWeek();
        
        // Charger l'employé avec sa position
        $employee->load('position');
        
        // Récupérer ou créer la timesheet pour cette période
        $timesheet = Timesheet::firstOrCreate([
            'employee_id' => $employee->id,
            'period_start' => $startDate->format('Y-m-d'),
            'period_end' => $endDate->format('Y-m-d'),
        ], [
            'status' => 'brouillon',
        ]);
        
        // Récupérer les entrées existantes
        $entries = TimesheetEntry::where('timesheet_id', $timesheet->id)
            ->get()
            ->keyBy('date');
        
        // Récupérer le planning de référence
        $planningAssignment = PlanningAssignment::where('employee_id', $employee->id)
            ->where('start_date', '<=', $startDate)
            ->where('end_date', '>=', $endDate)
            ->where('status', 'validé')
            ->with('planningModel')
            ->first();
        
        $planningHours = [];
        if ($planningAssignment) {
            $model = $planningAssignment->planningModel;
            $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
            foreach ($days as $index => $day) {
                $date = $startDate->copy()->addDays($index);
                $planningHours[$date->format('Y-m-d')] = $model->{$day . '_hours'};
            }
        }
        
        return Inertia::render('Timesheets/Show', [
            'employee' => $employee,
            'timesheet' => $timesheet,
            'entries' => $entries,
            'planningHours' => $planningHours,
            'startDate' => $startDate->format('Y-m-d'),
            'endDate' => $endDate->format('Y-m-d'),
            'planningAssignment' => $planningAssignment,
            'week' => $week,
        ]);
    }
    
public function store(Request $request, Employee $employee)
{
    $user = Auth::user();
    $this->authorizeAccess($user, $employee);
    
    $week = $request->get('week');
    $year = (int)substr($week, 0, 4);
    $weekNumber = (int)substr($week, 6);
    
    $startDate = Carbon::now()->setISODate($year, $weekNumber)->startOfWeek();
    $endDate = $startDate->copy()->endOfWeek();
    
    $timesheet = Timesheet::firstOrCreate([
        'employee_id' => $employee->id,
        'period_start' => $startDate->format('Y-m-d'),
        'period_end' => $endDate->format('Y-m-d'),
    ]);
    
    if ($timesheet->status === 'validé') {
        return back()->with('error', 'Cette feuille de temps est déjà validée.');
    }
    
    $entries = $request->get('entries', []);
    
   foreach ($entries as $date => $data) {
    $totalHours = 0;
    $plannedHours = isset($data['planned_hours']) ? (float)$data['planned_hours'] : 0;

    // 1. On vérifie si on a bien les deux heures
    if (!empty($data['check_in']) && !empty($data['check_out'])) {
        try {
            // Nettoyage de la chaîne (on ne garde que HH:mm même si on reçoit HH:mm:ss)
            $timeIn = substr($data['check_in'], 0, 5);
            $timeOut = substr($data['check_out'], 0, 5);

            $checkIn = Carbon::createFromFormat('H:i', $timeIn);
            $checkOut = Carbon::createFromFormat('H:i', $timeOut);

            // Gestion de la pause (s'assurer que c'est un entier)
            $breakMinutes = isset($data['break_duration']) ? (int)$data['break_duration'] : 0;

            // Calcul de la différence brute en minutes
            $diffInMinutes = $checkIn->diffInMinutes($checkOut, false); 
            
            // Si le résultat est négatif, c'est que le départ est le lendemain
            if ($diffInMinutes < 0) {
                $diffInMinutes += 1440; // On ajoute 24h en minutes
            }

            // Total heures = (Minutes travaillées - pause) / 60
            $totalHours = ($diffInMinutes - $breakMinutes) / 60;

        } catch (\Exception $e) {
            // En cas d'erreur de format, on laisse à 0 pour éviter le crash
            $totalHours = 0;
        }
    }

    // 2. Calcul de l'écart (Overtime)
    // Ici, on ne met PAS de max(0) sur le total_hours avant le calcul
    // car on veut que l'absence soit visible si les heures sont vides
    $overtimeHours = $totalHours - $plannedHours;

    TimesheetEntry::updateOrCreate([
        'timesheet_id' => $timesheet->id,
        'date' => $date,
    ], [
        'check_in' => $data['check_in'] ?: null,
        'check_out' => $data['check_out'] ?: null,
        'break_duration' => $data['break_duration'] ?? 0,
        'total_hours' => round($totalHours, 2),
        'planned_hours' => $plannedHours,
        'overtime_hours' => round($overtimeHours, 2),
        'absence_type' => $data['absence_type'] ?: null,
        'comment' => $data['comment'] ?: null,
    ]);
}
    
    $action = $request->get('action');
    $timesheet->status = ($action === 'submit') ? 'soumis' : 'brouillon';
    $timesheet->save();
    
    return redirect()->back()->with('success', 'Feuille de temps mise à jour.');
}
    
    public function validate(Request $request, Timesheet $timesheet)
    {
        $user = Auth::user();
        
        // Seul un CP peut valider
        if ($user->role->name !== 'cp') {
            abort(403, 'Action non autorisée.');
        }
        
        // Vérifier que le CP a le droit de valider cette timesheet
        $canValidate = Assignment::where('manager_id', $user->employee->id)
            ->where('employee_id', $timesheet->employee_id)
            ->where('status', 'actif')
            ->exists();
            
        if (!$canValidate) {
            abort(403, 'Vous n\'êtes pas autorisé à valider cette feuille de temps.');
        }
        
        $timesheet->status = 'validé';
        $timesheet->validated_by = $user->employee->id;
        $timesheet->validated_at = now();
        $timesheet->save();
        
        // Créer l'historique
        TimesheetHistory::create([
            'timesheet_id' => $timesheet->id,
            'employee_id' => $timesheet->employee_id,
            'old_status' => 'soumis',
            'new_status' => 'validé',
            'changed_by' => $user->employee->id,
            'reason' => 'Validation par le Chef de Plateau',
            'created_at' => now(),
        ]);
        
        return redirect()->back()->with('success', 'Feuille de temps validée avec succès.');
    }
    
    private function authorizeAccess($user, $employee)
    {
        $role = $user->role->name;
        
        if ($role === 'tc') {
            // TC ne peut voir que sa propre page
            if ($user->employee->id !== $employee->id) {
                abort(403, 'Accès non autorisé.');
            }
        } elseif ($role === 'sup') {
            // SUP peut voir ses TC
            $canAccess = Assignment::where('manager_id', $user->employee->id)
                ->where('employee_id', $employee->id)
                ->where('status', 'actif')
                ->exists();
                
            if (!$canAccess) {
                abort(403, 'Accès non autorisé.');
            }
        } elseif ($role === 'cp') {
            // CP peut voir ses superviseurs
            $canAccess = Assignment::where('manager_id', $user->employee->id)
                ->where('employee_id', $employee->id)
                ->where('status', 'actif')
                ->exists();
                
            if (!$canAccess) {
                abort(403, 'Accès non autorisé.');
            }
        }
    }
}
