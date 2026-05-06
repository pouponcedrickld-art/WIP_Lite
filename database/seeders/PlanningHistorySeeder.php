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
                    $query->select('id')->from('employees')->where('matricule', 'EMP0001');
                })->first()->id,
                'old_status' => null,
                'new_status' => 'validé',
                'changed_by' => User::first()->id,
                'reason' => 'Validation initiale du planning',
            ],
            [
                'planning_assignment_id' => PlanningAssignment::where('employee_id', function($query) {
                    $query->select('id')->from('employees')->where('matricule', 'EMP0002');
                })->first()->id,
                'old_status' => null,
                'new_status' => 'validé',
                'changed_by' => User::first()->id,
                'reason' => 'Validation initiale du planning',
            ],
            [
                'planning_assignment_id' => PlanningAssignment::where('employee_id', function($query) {
                    $query->select('id')->from('employees')->where('matricule', 'EMP0004');
                })->first()->id,
                'old_status' => 'en attente',
                'new_status' => 'suspendu',
                'changed_by' => User::first()->id,
                'reason' => 'Suspension temporaire du planning',
            ],
            [
                'planning_assignment_id' => PlanningAssignment::where('employee_id', function($query) {
                    $query->select('id')->from('employees')->where('matricule', 'EMP0003');
                })->first()->id,
                'old_status' => 'validé',
                'new_status' => 'terminé',
                'changed_by' => User::first()->id,
                'reason' => 'Fin de période de planning',
            ],
        ];

        foreach ($planningHistories as $planningHistory) {
            PlanningHistory::create($planningHistory);
        }
    }
}
