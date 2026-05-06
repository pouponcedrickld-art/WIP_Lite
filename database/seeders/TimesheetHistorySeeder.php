<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TimesheetHistory;
use App\Models\Timesheet;
use App\Models\Employee;

class TimesheetHistorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $timesheetHistories = [
            [
                'timesheet_id' => Timesheet::where('employee_id', function($query) {
                    $query->select('id')->from('employees')->where('matricule', 'EMP0001');
                })->first()->id,
                'employee_id' => Employee::where('matricule', 'EMP0001')->first()->id,
                'old_status' => 'soumis',
                'new_status' => 'validé',
                'changed_by' => Employee::where('matricule', 'EMP0002')->first()->id,
                'reason' => 'Validation de la feuille de temps',
                'created_at' => '2024-04-08 10:00:00',
            ],
            [
                'timesheet_id' => Timesheet::where('employee_id', function($query) {
                    $query->select('id')->from('employees')->where('matricule', 'EMP0002');
                })->first()->id,
                'employee_id' => Employee::where('matricule', 'EMP0002')->first()->id,
                'old_status' => 'brouillon',
                'new_status' => 'soumis',
                'changed_by' => Employee::where('matricule', 'EMP0002')->first()->id,
                'reason' => 'Soumission pour validation',
                'created_at' => '2024-04-07 16:00:00',
            ],
            [
                'timesheet_id' => Timesheet::where('employee_id', function($query) {
                    $query->select('id')->from('employees')->where('matricule', 'EMP0004');
                })->first()->id,
                'employee_id' => Employee::where('matricule', 'EMP0004')->first()->id,
                'old_status' => 'brouillon',
                'new_status' => 'validé',
                'changed_by' => Employee::where('matricule', 'EMP0001')->first()->id,
                'reason' => 'Validation directe par le manager',
                'created_at' => '2024-04-15 09:00:00',
            ],
        ];

        foreach ($timesheetHistories as $timesheetHistory) {
            TimesheetHistory::create($timesheetHistory);
        }
    }
}
