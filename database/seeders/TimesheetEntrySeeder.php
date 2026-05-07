<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TimesheetEntry;
use App\Models\Timesheet;

class TimesheetEntrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Récupérer les premiers timesheets créés
        $timesheets = Timesheet::limit(10)->get();
        
        if ($timesheets->count() < 1) {
            $this->command->error('Pas de timesheets trouvés pour créer les entries');
            return;
        }
        
        $timesheetEntries = [
            // Entries for first timesheet
            [
                'timesheet_id' => $timesheets[0]->id,
                'date' => '2024-04-01',
                'check_in' => '08:30:00',
                'check_out' => '17:30:00',
                'break_duration' => 60,
                'total_hours' => 8.00,
                'planned_hours' => 8.00,
                'overtime_hours' => 0.00,
                'comment' => null,
            ],
            [
                'timesheet_id' => $timesheets[0]->id,
                'date' => '2024-04-02',
                'check_in' => '08:45:00',
                'check_out' => '18:15:00',
                'break_duration' => 60,
                'total_hours' => 8.50,
                'planned_hours' => 8.00,
                'overtime_hours' => 0.50,
                'comment' => 'Réunion client prolongée',
            ],
            [
                'timesheet_id' => $timesheets[0]->id,
                'date' => '2024-04-03',
                'check_in' => null,
                'check_out' => null,
                'break_duration' => 0,
                'total_hours' => 0.00,
                'planned_hours' => 8.00,
                'overtime_hours' => 0.00,
                'absence_type' => 'congé',
                'comment' => 'Congé payé',
            ],
            // Entries for second timesheet
            [
                'timesheet_id' => $timesheets[1]->id,
                'date' => '2024-04-01',
                'check_in' => '09:00:00',
                'check_out' => '17:00:00',
                'break_duration' => 45,
                'total_hours' => 7.25,
                'planned_hours' => 8.00,
                'overtime_hours' => 0.00,
                'comment' => null,
            ],
            [
                'timesheet_id' => $timesheets[1]->id,
                'date' => '2024-04-02',
                'check_in' => '08:30:00',
                'check_out' => '19:30:00',
                'break_duration' => 60,
                'total_hours' => 9.50,
                'planned_hours' => 8.00,
                'overtime_hours' => 1.50,
                'comment' => 'Heures supplémentaires',
            ],
            // Entries for fourth timesheet
            [
                'timesheet_id' => $timesheets[3]->id,
                'date' => '2024-04-08',
                'check_in' => '08:15:00',
                'check_out' => '16:45:00',
                'break_duration' => 30,
                'total_hours' => 8.00,
                'planned_hours' => 8.00,
                'overtime_hours' => 0.00,
                'comment' => null,
            ],
        ];

        foreach ($timesheetEntries as $timesheetEntry) {
            TimesheetEntry::create($timesheetEntry);
        }
    }
}
