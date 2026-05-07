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
        // Récupérer les premiers planning assignments et utilisateurs créés
        $planningAssignments = PlanningAssignment::limit(10)->get();
        $users = User::limit(10)->get();
        
        if ($planningAssignments->count() < 1 || $users->count() < 1) {
            $this->command->error('Pas assez de données pour créer les planning histories');
            return;
        }
        
        $planningHistories = [
            [
                'planning_assignment_id' => $planningAssignments[0]->id,
                'old_status' => null,
                'new_status' => 'validé',
                'changed_by' => $users[0]->id,
                'reason' => 'Validation initiale du planning',
            ],
            [
                'planning_assignment_id' => $planningAssignments[1]->id,
                'old_status' => null,
                'new_status' => 'validé',
                'changed_by' => $users[0]->id,
                'reason' => 'Validation initiale du planning',
            ],
            [
                'planning_assignment_id' => $planningAssignments[2]->id,
                'old_status' => 'en attente',
                'new_status' => 'suspendu',
                'changed_by' => $users[0]->id,
                'reason' => 'Suspension temporaire du planning',
            ],
            [
                'planning_assignment_id' => $planningAssignments[3]->id,
                'old_status' => 'validé',
                'new_status' => 'terminé',
                'changed_by' => $users[0]->id,
                'reason' => 'Fin de période de planning',
            ],
        ];

        foreach ($planningHistories as $planningHistory) {
            PlanningHistory::create($planningHistory);
        }
    }
}
