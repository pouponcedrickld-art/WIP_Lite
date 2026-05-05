<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PlanningHistory;
use App\Models\PlanningAssignment;
use App\Models\User;

class PlanningHistorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $planningHistories = [
            [
                'planning_assignment_id' => PlanningAssignment::where('employee_id', function($query) {
                    $query->select('id')->from('employees')->where('matricule', 'EMP0003');
                })->first()->id,
                'old_status' => 'en attente',
                'new_status' => 'validé',
                'changed_by' => User::first()->id,
                'reason' => 'Validation du planning standard pour Pierre Durand',
            ],
            [
                'planning_assignment_id' => PlanningAssignment::where('employee_id', function($query) {
                    $query->select('id')->from('employees')->where('matricule', 'EMP0005');
                })->first()->id,
                'old_status' => 'en attente',
                'new_status' => 'validé',
                'changed_by' => User::first()->id,
                'reason' => 'Validation du planning pour Thomas Bernard',
            ],
            [
                'planning_assignment_id' => PlanningAssignment::where('employee_id', function($query) {
                    $query->select('id')->from('employees')->where('matricule', 'EMP0006');
                })->first()->id,
                'old_status' => 'en attente',
                'new_status' => 'validé',
                'changed_by' => User::first()->id,
                'reason' => 'Validation du planning temps partiel pour Camille Petit',
            ],
            [
                'planning_assignment_id' => PlanningAssignment::where('employee_id', function($query) {
                    $query->select('id')->from('employees')->where('matricule', 'EMP0007');
                })->first()->id,
                'old_status' => 'validé',
                'new_status' => 'suspendu',
                'changed_by' => User::first()->id,
                'reason' => 'Suspension temporaire du planning pour Nicolas Robert',
            ],
            [
                'planning_assignment_id' => PlanningAssignment::where('employee_id', function($query) {
                    $query->select('id')->from('employees')->where('matricule', 'EMP0008');
                })->first()->id,
                'old_status' => null,
                'new_status' => 'en attente',
                'changed_by' => User::first()->id,
                'reason' => 'Création du planning en attente pour Isabelle Dubois',
            ],
        ];

        foreach ($planningHistories as $planningHistory) {
            PlanningHistory::create($planningHistory);
        }
    }
}
