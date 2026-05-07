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
        // Récupérer les premières données créées
        $assignments = Assignment::limit(10)->get();
        $employees = Employee::limit(10)->get();
        $campaigns = Campaign::limit(10)->get();
        $users = User::limit(10)->get();
        
        if ($assignments->count() < 1 || $employees->count() < 2 || $campaigns->count() < 1 || $users->count() < 1) {
            $this->command->error('Pas assez de données pour créer les assignment histories');
            return;
        }
        
        $assignmentHistories = [
            [
                'assignment_id' => $assignments[0]->id,
                'employee_id' => $employees[0]->id,
                'old_manager_id' => null,
                'new_manager_id' => $employees[1]->id,
                'old_campaign_id' => null,
                'new_campaign_id' => $campaigns[0]->id,
                'action_type' => 'assign',
                'changed_by' => $users[0]->id,
                'reason' => 'Affectation initiale projet e-commerce',
            ],
            [
                'assignment_id' => $assignments[1]->id,
                'employee_id' => $employees[2]->id,
                'old_manager_id' => $employees[1]->id,
                'new_manager_id' => $employees[3]->id,
                'old_campaign_id' => $campaigns[0]->id,
                'new_campaign_id' => $campaigns[1]->id,
                'action_type' => 'transfer',
                'changed_by' => $users[0]->id,
                'reason' => 'Changement de projet et manager',
            ],
            [
                'assignment_id' => $assignments[2]->id,
                'employee_id' => $employees[3]->id,
                'old_manager_id' => null,
                'new_manager_id' => $employees[1]->id,
                'old_campaign_id' => null,
                'new_campaign_id' => $campaigns[2]->id,
                'action_type' => 'assign',
                'changed_by' => $users[0]->id,
                'reason' => 'Nouvelle affectation au projet CRM',
            ],
        ];

        foreach ($assignmentHistories as $assignmentHistory) {
            AssignmentHistory::create($assignmentHistory);
        }
    }
}
