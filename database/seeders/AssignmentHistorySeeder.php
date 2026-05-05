<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\AssignmentHistory;
use App\Models\Assignment;
use App\Models\Employee;
use App\Models\Campaign;
use App\Models\User;

class AssignmentHistorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $assignmentHistories = [
            [
                'assignment_id' => Assignment::where('employee_id', function($query) {
                    $query->select('id')->from('employees')->where('matricule', 'EMP0001');
                })->first()->id,
                'employee_id' => Employee::where('matricule', 'EMP0001')->first()->id,
                'old_manager_id' => null,
                'new_manager_id' => Employee::where('matricule', 'EMP0002')->first()->id,
                'old_campaign_id' => null,
                'new_campaign_id' => Campaign::where('name', 'Refonte Site E-commerce')->first()->id,
                'action_type' => 'assign',
                'changed_by' => User::first()->id,
                'reason' => 'Affectation initiale projet e-commerce',
            ],
            [
                'assignment_id' => Assignment::where('employee_id', function($query) {
                    $query->select('id')->from('employees')->where('matricule', 'EMP0003');
                })->first()->id,
                'employee_id' => Employee::where('matricule', 'EMP0003')->first()->id,
                'old_manager_id' => Employee::where('matricule', 'EMP0002')->first()->id,
                'new_manager_id' => Employee::where('matricule', 'EMP0004')->first()->id,
                'old_campaign_id' => Campaign::where('name', 'Refonte Site E-commerce')->first()->id,
                'new_campaign_id' => Campaign::where('name', 'Application Mobile Banking')->first()->id,
                'action_type' => 'transfer',
                'changed_by' => User::first()->id,
                'reason' => 'Changement de projet et manager',
            ],
            [
                'assignment_id' => Assignment::where('employee_id', function($query) {
                    $query->select('id')->from('employees')->where('matricule', 'EMP0004');
                })->first()->id,
                'employee_id' => Employee::where('matricule', 'EMP0004')->first()->id,
                'old_manager_id' => null,
                'new_manager_id' => Employee::where('matricule', 'EMP0002')->first()->id,
                'old_campaign_id' => null,
                'new_campaign_id' => Campaign::where('name', 'CRM Integration')->first()->id,
                'action_type' => 'assign',
                'changed_by' => User::first()->id,
                'reason' => 'Nouvelle affectation au projet CRM',
            ],
        ];

        foreach ($assignmentHistories as $assignmentHistory) {
            AssignmentHistory::create($assignmentHistory);
        }
    }
}
