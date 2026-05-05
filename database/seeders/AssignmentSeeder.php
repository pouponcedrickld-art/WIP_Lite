<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Assignment;
use App\Models\Employee;
use App\Models\Campaign;
use App\Models\Position;

class AssignmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $assignments = [
            [
                'employee_id' => Employee::where('matricule', 'EMP0002')->first()->id, // Marie Martin - CP
                'campaign_id' => Campaign::where('name', 'Refonte Site E-commerce')->first()->id,
                'manager_id' => Employee::where('matricule', 'EMP0001')->first()->id, // Jean Dupont - Manager
                'position_id' => Position::where('code', 'CP')->first()->id,
                'status' => 'actif',
                'start_date' => '2024-01-15',
                'end_date' => '2024-06-30',
            ],
            [
                'employee_id' => Employee::where('matricule', 'EMP0003')->first()->id, // Pierre Durand - Dev Senior
                'campaign_id' => Campaign::where('name', 'Refonte Site E-commerce')->first()->id,
                'manager_id' => Employee::where('matricule', 'EMP0002')->first()->id, // Marie Martin - CP
                'position_id' => Position::where('code', 'DEV_SR')->first()->id,
                'status' => 'actif',
                'start_date' => '2024-01-20',
                'end_date' => '2024-06-30',
            ],
            [
                'employee_id' => Employee::where('matricule', 'EMP0004')->first()->id, // Sophie Lefebvre - Superviseur
                'campaign_id' => Campaign::where('name', 'Application Mobile Banking')->first()->id,
                'manager_id' => Employee::where('matricule', 'EMP0001')->first()->id, // Jean Dupont - Manager
                'position_id' => Position::where('code', 'SUP')->first()->id,
                'status' => 'actif',
                'start_date' => '2024-02-01',
                'end_date' => '2024-12-31',
            ],
            [
                'employee_id' => Employee::where('matricule', 'EMP0005')->first()->id, // Thomas Bernard - Dev Junior
                'campaign_id' => Campaign::where('name', 'Application Mobile Banking')->first()->id,
                'manager_id' => Employee::where('matricule', 'EMP0004')->first()->id, // Sophie Lefebvre - Superviseur
                'position_id' => Position::where('code', 'DEV_JR')->first()->id,
                'status' => 'actif',
                'start_date' => '2024-02-15',
                'end_date' => '2024-12-31',
            ],
            [
                'employee_id' => Employee::where('matricule', 'EMP0006')->first()->id, // Camille Petit - Analyste
                'campaign_id' => Campaign::where('name', 'CRM Integration')->first()->id,
                'manager_id' => Employee::where('matricule', 'EMP0002')->first()->id, // Marie Martin - CP
                'position_id' => Position::where('code', 'ANA')->first()->id,
                'status' => 'actif',
                'start_date' => '2024-03-15',
                'end_date' => '2024-08-15',
            ],
            [
                'employee_id' => Employee::where('matricule', 'EMP0007')->first()->id, // Nicolas Robert - Technicien
                'campaign_id' => Campaign::where('name', 'Migration Cloud Infrastructure')->first()->id,
                'manager_id' => Employee::where('matricule', 'EMP0001')->first()->id, // Jean Dupont - Manager
                'position_id' => Position::where('code', 'TECH')->first()->id,
                'status' => 'terminé',
                'start_date' => '2023-09-01',
                'end_date' => '2024-03-31',
            ],
            [
                'employee_id' => Employee::where('matricule', 'EMP0008')->first()->id, // Isabelle Dubois - Designer
                'campaign_id' => Campaign::where('name', 'Data Analytics Platform')->first()->id,
                'manager_id' => Employee::where('matricule', 'EMP0002')->first()->id, // Marie Martin - CP
                'position_id' => Position::where('code', 'DES')->first()->id,
                'status' => 'actif',
                'start_date' => '2024-05-01',
                'end_date' => '2024-11-30',
            ],
        ];

        foreach ($assignments as $assignment) {
            Assignment::create($assignment);
        }
    }
}
