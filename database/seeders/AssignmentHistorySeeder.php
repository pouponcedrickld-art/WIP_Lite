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
                    $query->select('id')->from('employees')->where('matricule', 'EMP0003');
                })->first()->id,
                'employee_id' => Employee::where('matricule', 'EMP0003')->first()->id, // Pierre Durand
                'old_manager_id' => null,
                'new_manager_id' => Employee::where('matricule', 'EMP0002')->first()->id, // Marie Martin
                'old_campaign_id' => null,
                'new_campaign_id' => Campaign::where('name', 'Refonte Site E-commerce')->first()->id,
                'action_type' => 'assign',
                'changed_by' => User::first()->id,
                'reason' => 'Affectation initiale au projet e-commerce',
            ],
            [
                'assignment_id' => Assignment::where('employee_id', function($query) {
                    $query->select('id')->from('employees')->where('matricule', 'EMP0005');
                })->first()->id,
                'employee_id' => Employee::where('matricule', 'EMP0005')->first()->id, // Thomas Bernard
                'old_manager_id' => null,
                'new_manager_id' => Employee::where('matricule', 'EMP0004')->first()->id, // Sophie Lefebvre
                'old_campaign_id' => null,
                'new_campaign_id' => Campaign::where('name', 'Application Mobile Banking')->first()->id,
                'action_type' => 'assign',
                'changed_by' => User::first()->id,
                'reason' => 'Nouvelle affectation projet mobile',
            ],
            [
                'assignment_id' => Assignment::where('employee_id', function($query) {
                    $query->select('id')->from('employees')->where('matricule', 'EMP0007');
                })->first()->id,
                'employee_id' => Employee::where('matricule', 'EMP0007')->first()->id, // Nicolas Robert
                'old_manager_id' => Employee::where('matricule', 'EMP0001')->first()->id, // Jean Dupont
                'new_manager_id' => null,
                'old_campaign_id' => Campaign::where('name', 'Migration Cloud Infrastructure')->first()->id,
                'new_campaign_id' => null,
                'action_type' => 'release',
                'changed_by' => User::first()->id,
                'reason' => 'Fin de projet migration cloud',
            ],
            [
                'assignment_id' => Assignment::where('employee_id', function($query) {
                    $query->select('id')->from('employees')->where('matricule', 'EMP0006');
                })->first()->id,
                'employee_id' => Employee::where('matricule', 'EMP0006')->first()->id, // Camille Petit
                'old_manager_id' => null,
                'new_manager_id' => Employee::where('matricule', 'EMP0002')->first()->id, // Marie Martin
                'old_campaign_id' => null,
                'new_campaign_id' => Campaign::where('name', 'CRM Integration')->first()->id,
                'action_type' => 'assign',
                'changed_by' => User::first()->id,
                'reason' => 'Affectation au projet CRM',
            ],
        ];

        foreach ($assignmentHistories as $assignmentHistory) {
            AssignmentHistory::create($assignmentHistory);
        }
    }
}
