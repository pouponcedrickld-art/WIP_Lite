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
        $timesheets = [
            [
                'employee_id' => Employee::where('matricule', 'EMP0001')->first()->id,
                'period_start' => '2024-04-01',
                'period_end' => '2024-04-07',
                'status' => 'validé',
                'validated_by' => Employee::where('matricule', 'EMP0002')->first()->id,
                'validated_at' => '2024-04-08 10:00:00',
            ],
            [
                'employee_id' => Employee::where('matricule', 'EMP0002')->first()->id,
                'period_start' => '2024-04-01',
                'period_end' => '2024-04-07',
                'status' => 'soumis',
                'validated_by' => null,
                'validated_at' => null,
            ],
            [
                'employee_id' => Employee::where('matricule', 'EMP0003')->first()->id,
                'period_start' => '2024-04-01',
                'period_end' => '2024-04-07',
                'status' => 'brouillon',
                'validated_by' => null,
                'validated_at' => null,
            ],
            [
                'employee_id' => Employee::where('matricule', 'EMP0004')->first()->id,
                'period_start' => '2024-04-08',
                'period_end' => '2024-04-14',
                'status' => 'validé',
                'validated_by' => Employee::where('matricule', 'EMP0001')->first()->id,
                'validated_at' => '2024-04-15 09:00:00',
            ],
        ];

        foreach ($timesheets as $timesheet) {
            Timesheet::create($timesheet);
        }
    }
}
