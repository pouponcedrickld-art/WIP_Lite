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
                'employee_id' => Employee::where('matricule', 'EMP0001')->first()->id,
                'campaign_id' => Campaign::where('name', 'Refonte Site E-commerce')->first()->id,
                'manager_id' => Employee::where('matricule', 'EMP0002')->first()->id,
                'position_id' => Position::where('code', 'RH')->first()->id,
                'status' => 'actif',
                'start_date' => '2024-01-15',
                'end_date' => '2024-06-30',
            ],
            [
                'employee_id' => Employee::where('matricule', 'EMP0003')->first()->id,
                'campaign_id' => Campaign::where('name', 'Refonte Site E-commerce')->first()->id,
                'manager_id' => Employee::where('matricule', 'EMP0002')->first()->id,
                'position_id' => Position::where('code', 'CP')->first()->id,
                'status' => 'actif',
                'start_date' => '2024-01-20',
                'end_date' => '2024-06-30',
            ],
            [
                'employee_id' => Employee::where('matricule', 'EMP0004')->first()->id,
                'campaign_id' => Campaign::where('name', 'Application Mobile Banking')->first()->id,
                'manager_id' => Employee::where('matricule', 'EMP0001')->first()->id,
                'position_id' => Position::where('code', 'SUP')->first()->id,
                'status' => 'actif',
                'start_date' => '2024-02-01',
                'end_date' => '2024-12-31',
            ],
            [
                'employee_id' => Employee::where('matricule', 'EMP0003')->first()->id,
                'campaign_id' => Campaign::where('name', 'Application Mobile Banking')->first()->id,
                'manager_id' => Employee::where('matricule', 'EMP0004')->first()->id,
                'position_id' => Position::where('code', 'CP')->first()->id,
                'status' => 'actif',
                'start_date' => '2024-02-15',
                'end_date' => '2024-12-31',
            ],
            [
                'employee_id' => Employee::where('matricule', 'EMP0004')->first()->id,
                'campaign_id' => Campaign::where('name', 'CRM Integration')->first()->id,
                'manager_id' => Employee::where('matricule', 'EMP0002')->first()->id,
                'position_id' => Position::where('code', 'SUP')->first()->id,
                'status' => 'actif',
                'start_date' => '2024-03-15',
                'end_date' => '2024-08-15',
            ],
        ];

        foreach ($assignments as $assignment) {
            Assignment::create($assignment);
        }
    }
}
