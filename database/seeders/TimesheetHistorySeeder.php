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
                    $query->select('id')->from('employees')->where('matricule', 'EMP0003');
                })->where('period_start', '2024-04-01')->first()->id,
                'employee_id' => Employee::where('matricule', 'EMP0003')->first()->id, // Pierre Durand
                'old_status' => 'brouillon',
                'new_status' => 'soumis',
                'changed_by' => Employee::where('matricule', 'EMP0003')->first()->id,
                'reason' => 'Soumission de la feuille de temps pour validation',
            ],
            [
                'timesheet_id' => Timesheet::where('employee_id', function($query) {
                    $query->select('id')->from('employees')->where('matricule', 'EMP0003');
                })->where('period_start', '2024-04-01')->first()->id,
                'employee_id' => Employee::where('matricule', 'EMP0003')->first()->id, // Pierre Durand
                'old_status' => 'soumis',
                'new_status' => 'validé',
                'changed_by' => Employee::where('matricule', 'EMP0004')->first()->id, // Sophie Lefebvre
                'reason' => 'Validation de la feuille de temps par le superviseur',
            ],
            [
                'timesheet_id' => Timesheet::where('employee_id', function($query) {
                    $query->select('id')->from('employees')->where('matricule', 'EMP0005');
                })->where('period_start', '2024-04-01')->first()->id,
                'employee_id' => Employee::where('matricule', 'EMP0005')->first()->id, // Thomas Bernard
                'old_status' => 'brouillon',
                'new_status' => 'soumis',
                'changed_by' => Employee::where('matricule', 'EMP0005')->first()->id,
                'reason' => 'Soumission de la feuille de temps pour validation',
            ],
            [
                'timesheet_id' => Timesheet::where('employee_id', function($query) {
                    $query->select('id')->from('employees')->where('matricule', 'EMP0008');
                })->where('period_start', '2024-04-01')->first()->id,
                'employee_id' => Employee::where('matricule', 'EMP0008')->first()->id, // Isabelle Dubois
                'old_status' => 'brouillon',
                'new_status' => 'soumis',
                'changed_by' => Employee::where('matricule', 'EMP0008')->first()->id,
                'reason' => 'Soumission de la feuille de temps avec congés',
            ],
            [
                'timesheet_id' => Timesheet::where('employee_id', function($query) {
                    $query->select('id')->from('employees')->where('matricule', 'EMP0008');
                })->where('period_start', '2024-04-01')->first()->id,
                'employee_id' => Employee::where('matricule', 'EMP0008')->first()->id, // Isabelle Dubois
                'old_status' => 'soumis',
                'new_status' => 'validé',
                'changed_by' => Employee::where('matricule', 'EMP0002')->first()->id, // Marie Martin
                'reason' => 'Validation de la feuille de temps avec congés payés',
            ],
        ];

        foreach ($timesheetHistories as $timesheetHistory) {
            TimesheetHistory::create($timesheetHistory);
        }
    }
}
