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
        $planningAssignments = [
            [
                'planning_model_id' => PlanningModel::where('name', 'Semaine Standard 40h')->first()->id,
                'employee_id' => Employee::where('matricule', 'EMP0003')->first()->id, // Pierre Durand
                'start_date' => '2024-01-01',
                'end_date' => '2024-12-31',
                'status' => 'validé',
                'validated_by' => Employee::where('matricule', 'EMP0001')->first()->id, // Jean Dupont
                'validated_at' => '2024-01-01 09:00:00',
            ],
            [
                'planning_model_id' => PlanningModel::where('name', 'Semaine Standard 40h')->first()->id,
                'employee_id' => Employee::where('matricule', 'EMP0005')->first()->id, // Thomas Bernard
                'start_date' => '2024-02-15',
                'end_date' => '2024-12-31',
                'status' => 'validé',
                'validated_by' => Employee::where('matricule', 'EMP0004')->first()->id, // Sophie Lefebvre
                'validated_at' => '2024-02-15 10:00:00',
            ],
            [
                'planning_model_id' => PlanningModel::where('name', 'Semaine 35h')->first()->id,
                'employee_id' => Employee::where('matricule', 'EMP0006')->first()->id, // Camille Petit
                'start_date' => '2024-03-15',
                'end_date' => '2024-08-15',
                'status' => 'validé',
                'validated_by' => Employee::where('matricule', 'EMP0002')->first()->id, // Marie Martin
                'validated_at' => '2024-03-15 11:00:00',
            ],
            [
                'planning_model_id' => PlanningModel::where('name', 'Horaires flexibles')->first()->id,
                'employee_id' => Employee::where('matricule', 'EMP0008')->first()->id, // Isabelle Dubois
                'start_date' => '2024-05-01',
                'end_date' => '2024-11-30',
                'status' => 'en attente',
                'validated_by' => null,
                'validated_at' => null,
            ],
            [
                'planning_model_id' => PlanningModel::where('name', 'Temps partiel 20h')->first()->id,
                'employee_id' => Employee::where('matricule', 'EMP0007')->first()->id, // Nicolas Robert
                'start_date' => '2024-04-01',
                'end_date' => '2024-09-30',
                'status' => 'suspendu',
                'validated_by' => Employee::where('matricule', 'EMP0001')->first()->id, // Jean Dupont
                'validated_at' => '2024-04-01 14:00:00',
            ],
        ];

        foreach ($planningAssignments as $planningAssignment) {
            PlanningAssignment::create($planningAssignment);
        }
    }
}
