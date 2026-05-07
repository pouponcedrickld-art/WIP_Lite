<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PlanningAssignment;
use App\Models\PlanningModel;
use App\Models\Employee;

class PlanningAssignmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Récupérer les premiers employés créés
        $employees = Employee::limit(10)->get();
        $planningModel = PlanningModel::where('name', 'Semaine Standard 40h')->first();
        
        if (!$planningModel || $employees->count() < 2) {
            $this->command->error('Planning model ou employés non trouvés');
            return;
        }
        
        $planningAssignments = [
            [
                'planning_model_id' => $planningModel->id,
                'employee_id' => $employees[0]->id,
                'start_date' => '2024-01-01',
                'end_date' => '2024-12-31',
                'status' => 'validé',
                'validated_by' => $employees[1]->id,
                'validated_at' => '2024-01-01 09:00:00',
            ],
            [
                'planning_model_id' => $planningModel->id,
                'employee_id' => $employees[1]->id,
                'start_date' => '2024-01-01',
                'end_date' => '2024-12-31',
                'status' => 'validé',
                'validated_by' => $employees[0]->id,
                'validated_at' => '2024-01-01 10:00:00',
            ],
            [
                'planning_model_id' => PlanningModel::where('name', 'Semaine 35h')->first()->id,
                'employee_id' => $employees[2]->id,
                'start_date' => '2024-02-15',
                'end_date' => '2024-12-31',
                'status' => 'validé',
                'validated_by' => $employees[0]->id,
                'validated_at' => '2024-02-15 11:00:00',
            ],
            [
                'planning_model_id' => PlanningModel::where('name', 'Horaires flexibles')->first()->id,
                'employee_id' => $employees[3]->id,
                'start_date' => '2024-03-01',
                'end_date' => '2024-12-31',
                'status' => 'en attente',
                'validated_by' => null,
                'validated_at' => null,
            ],
            [
                'planning_model_id' => PlanningModel::where('name', 'Temps partiel 20h')->first()->id,
                'employee_id' => $employees[4]->id,
                'start_date' => '2024-04-01',
                'end_date' => '2024-09-30',
                'status' => 'suspendu',
                'validated_by' => $employees[1]->id,
                'validated_at' => '2024-04-01 14:00:00',
            ],
        ];

        foreach ($planningAssignments as $planningAssignment) {
            PlanningAssignment::create($planningAssignment);
        }
    }
}
