<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\EmployeeHistory;
use App\Models\Employee;
use App\Models\Position;
use App\Models\User;

class EmployeeHistorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Récupérer les premiers employés et positions créés
        $employees = Employee::limit(10)->get();
        $positions = Position::limit(10)->get();
        $users = User::limit(10)->get();
        
        if ($employees->count() < 2 || $positions->count() < 3 || $users->count() < 1) {
            $this->command->error('Pas assez de données pour créer les employee histories');
            return;
        }
        
        $employeeHistories = [
            [
                'employee_id' => $employees[0]->id,
                'old_position_id' => $positions[0]->id,
                'new_position_id' => $positions[1]->id,
                'old_status' => 'actif',
                'new_status' => 'actif',
                'changed_by' => $users[0]->id,
                'reason' => 'Promotion aux Ressources Humaines',
            ],
            [
                'employee_id' => $employees[1]->id,
                'old_position_id' => $positions[2]->id,
                'new_position_id' => $positions[0]->id,
                'old_status' => 'actif',
                'new_status' => 'actif',
                'changed_by' => $users[0]->id,
                'reason' => 'Évolution vers le poste de ChefProjet',
            ],
            [
                'employee_id' => $employees[2]->id,
                'old_position_id' => $positions[2]->id,
                'new_position_id' => $positions[0]->id,
                'old_status' => 'actif',
                'new_status' => 'actif',
                'changed_by' => $users[0]->id,
                'reason' => 'Promotion au poste de ChefProjet après expérience',
            ],
            [
                'employee_id' => $employees[3]->id,
                'old_position_id' => $positions[2]->id,
                'new_position_id' => $positions[2]->id,
                'old_status' => 'actif',
                'new_status' => 'actif',
                'changed_by' => $users[0]->id,
                'reason' => 'Promotion au poste de Superviseur',
            ],
        ];

        foreach ($employeeHistories as $employeeHistory) {
            EmployeeHistory::create($employeeHistory);
        }
    }
}
