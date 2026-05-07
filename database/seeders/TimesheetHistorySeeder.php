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
        // Récupérer les premiers timesheets et employés créés
        $timesheets = Timesheet::limit(10)->get();
        $employees = Employee::limit(10)->get();
        
        if ($timesheets->count() < 1 || $employees->count() < 2) {
            $this->command->error('Pas assez de données pour créer les timesheet histories');
            return;
        }
        
        $timesheetHistories = [
            [
                'timesheet_id' => $timesheets[0]->id,
                'employee_id' => $employees[0]->id,
                'old_status' => 'soumis',
                'new_status' => 'validé',
                'changed_by' => $employees[1]->id,
                'reason' => 'Validation de la feuille de temps',
                'created_at' => '2024-04-08 10:00:00',
            ],
            [
                'timesheet_id' => $timesheets[1]->id,
                'employee_id' => $employees[1]->id,
                'old_status' => 'brouillon',
                'new_status' => 'soumis',
                'changed_by' => $employees[1]->id,
                'reason' => 'Soumission pour validation',
                'created_at' => '2024-04-07 16:00:00',
            ],
            [
                'timesheet_id' => $timesheets[2]->id,
                'employee_id' => $employees[2]->id,
                'old_status' => 'brouillon',
                'new_status' => 'validé',
                'changed_by' => $employees[0]->id,
                'reason' => 'Validation directe par le manager',
                'created_at' => '2024-04-15 09:00:00',
            ],
        ];

        foreach ($timesheetHistories as $timesheetHistory) {
            TimesheetHistory::create($timesheetHistory);
        }
    }
}
