<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Timesheet;
use App\Models\Employee;

class TimesheetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Récupérer les premiers employés créés
        $employees = Employee::limit(10)->get();
        
        if ($employees->count() < 2) {
            $this->command->error('Pas assez d\'employés pour créer les timesheets');
            return;
        }
        
        $timesheets = [
            [
                'employee_id' => $employees[0]->id,
                'period_start' => '2024-04-01',
                'period_end' => '2024-04-07',
                'status' => 'validé',
                'validated_by' => $employees[1]->id,
                'validated_at' => '2024-04-08 10:00:00',
            ],
            [
                'employee_id' => $employees[1]->id,
                'period_start' => '2024-04-01',
                'period_end' => '2024-04-07',
                'status' => 'soumis',
                'validated_by' => null,
                'validated_at' => null,
            ],
            [
                'employee_id' => $employees[2]->id,
                'period_start' => '2024-04-01',
                'period_end' => '2024-04-07',
                'status' => 'brouillon',
                'validated_by' => null,
                'validated_at' => null,
            ],
            [
                'employee_id' => $employees[3]->id,
                'period_start' => '2024-04-08',
                'period_end' => '2024-04-14',
                'status' => 'validé',
                'validated_by' => $employees[0]->id,
                'validated_at' => '2024-04-15 09:00:00',
            ],
        ];

        foreach ($timesheets as $timesheet) {
            Timesheet::create($timesheet);
        }
    }
}
