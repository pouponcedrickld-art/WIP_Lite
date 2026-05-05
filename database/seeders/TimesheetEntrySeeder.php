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
        // Get the first timesheet for Pierre Durand (validated)
        $timesheet1 = Timesheet::where('employee_id', function($query) {
            $query->select('id')->from('employees')->where('matricule', 'EMP0003');
        })->where('period_start', '2024-04-01')->first();

        if ($timesheet1) {
            $entries1 = [
                [
                    'timesheet_id' => $timesheet1->id,
                    'date' => '2024-04-01',
                    'check_in' => '08:30',
                    'check_out' => '17:30',
                    'break_duration' => 60,
                    'total_hours' => 8.00,
                    'planned_hours' => 8.00,
                    'overtime_hours' => 0.00,
                    'comment' => 'Lundi standard',
                ],
                [
                    'timesheet_id' => $timesheet1->id,
                    'date' => '2024-04-02',
                    'check_in' => '08:15',
                    'check_out' => '18:15',
                    'break_duration' => 60,
                    'total_hours' => 9.50,
                    'planned_hours' => 8.00,
                    'overtime_hours' => 1.50,
                    'comment' => 'Heures supplémentaires pour projet urgent',
                ],
                [
                    'timesheet_id' => $timesheet1->id,
                    'date' => '2024-04-03',
                    'check_in' => '08:45',
                    'check_out' => '17:15',
                    'break_duration' => 45,
                    'total_hours' => 7.75,
                    'planned_hours' => 8.00,
                    'overtime_hours' => 0.00,
                    'comment' => 'Rendez-vous médical le matin',
                ],
                [
                    'timesheet_id' => $timesheet1->id,
                    'date' => '2024-04-04',
                    'check_in' => '08:30',
                    'check_out' => '17:30',
                    'break_duration' => 60,
                    'total_hours' => 8.00,
                    'planned_hours' => 8.00,
                    'overtime_hours' => 0.00,
                    'comment' => 'Jeudi normal',
                ],
                [
                    'timesheet_id' => $timesheet1->id,
                    'date' => '2024-04-05',
                    'check_in' => '08:00',
                    'check_out' => '16:00',
                    'break_duration' => 30,
                    'total_hours' => 7.50,
                    'planned_hours' => 8.00,
                    'overtime_hours' => 0.00,
                    'comment' => 'Départ anticipé',
                ],
            ];

            foreach ($entries1 as $entry) {
                TimesheetEntry::create($entry);
            }
        }

        // Get the timesheet for Thomas Bernard (submitted)
        $timesheet2 = Timesheet::where('employee_id', function($query) {
            $query->select('id')->from('employees')->where('matricule', 'EMP0005');
        })->where('period_start', '2024-04-01')->first();

        if ($timesheet2) {
            $entries2 = [
                [
                    'timesheet_id' => $timesheet2->id,
                    'date' => '2024-04-01',
                    'check_in' => '09:00',
                    'check_out' => '18:00',
                    'break_duration' => 60,
                    'total_hours' => 8.00,
                    'planned_hours' => 8.00,
                    'overtime_hours' => 0.00,
                    'comment' => 'Premier jour de la semaine',
                ],
                [
                    'timesheet_id' => $timesheet2->id,
                    'date' => '2024-04-02',
                    'check_in' => '08:45',
                    'check_out' => '17:45',
                    'break_duration' => 60,
                    'total_hours' => 8.00,
                    'planned_hours' => 8.00,
                    'overtime_hours' => 0.00,
                    'comment' => 'Formation interne',
                ],
                [
                    'timesheet_id' => $timesheet2->id,
                    'date' => '2024-04-03',
                    'check_in' => '08:30',
                    'check_out' => '17:30',
                    'break_duration' => 60,
                    'total_hours' => 8.00,
                    'planned_hours' => 8.00,
                    'overtime_hours' => 0.00,
                    'comment' => 'Développement feature',
                ],
                [
                    'timesheet_id' => $timesheet2->id,
                    'date' => '2024-04-04',
                    'check_in' => '08:30',
                    'check_out' => '17:30',
                    'break_duration' => 60,
                    'total_hours' => 8.00,
                    'planned_hours' => 8.00,
                    'overtime_hours' => 0.00,
                    'comment' => 'Code review',
                ],
                [
                    'timesheet_id' => $timesheet2->id,
                    'date' => '2024-04-05',
                    'check_in' => '08:30',
                    'check_out' => '17:30',
                    'break_duration' => 60,
                    'total_hours' => 8.00,
                    'planned_hours' => 8.00,
                    'overtime_hours' => 0.00,
                    'comment' => 'Réunion équipe',
                ],
            ];

            foreach ($entries2 as $entry) {
                TimesheetEntry::create($entry);
            }
        }

        // Get the timesheet for Isabelle Dubois (validated)
        $timesheet3 = Timesheet::where('employee_id', function($query) {
            $query->select('id')->from('employees')->where('matricule', 'EMP0008');
        })->where('period_start', '2024-04-01')->first();

        if ($timesheet3) {
            $entries3 = [
                [
                    'timesheet_id' => $timesheet3->id,
                    'date' => '2024-04-01',
                    'check_in' => '09:00',
                    'check_out' => '18:00',
                    'break_duration' => 60,
                    'total_hours' => 8.00,
                    'planned_hours' => 8.00,
                    'overtime_hours' => 0.00,
                    'comment' => 'Design sprint',
                ],
                [
                    'timesheet_id' => $timesheet3->id,
                    'date' => '2024-04-02',
                    'check_in' => '09:00',
                    'check_out' => '18:00',
                    'break_duration' => 60,
                    'total_hours' => 8.00,
                    'planned_hours' => 8.00,
                    'overtime_hours' => 0.00,
                    'comment' => 'Création maquettes',
                ],
                [
                    'timesheet_id' => $timesheet3->id,
                    'date' => '2024-04-03',
                    'check_in' => null,
                    'check_out' => null,
                    'break_duration' => 0,
                    'total_hours' => 0.00,
                    'planned_hours' => 8.00,
                    'overtime_hours' => 0.00,
                    'absence_type' => 'Congé payé',
                    'comment' => 'Congé payé',
                ],
                [
                    'timesheet_id' => $timesheet3->id,
                    'date' => '2024-04-04',
                    'check_in' => null,
                    'check_out' => null,
                    'break_duration' => 0,
                    'total_hours' => 0.00,
                    'planned_hours' => 8.00,
                    'overtime_hours' => 0.00,
                    'absence_type' => 'Congé payé',
                    'comment' => 'Congé payé',
                ],
                [
                    'timesheet_id' => $timesheet3->id,
                    'date' => '2024-04-05',
                    'check_in' => '09:00',
                    'check_out' => '18:00',
                    'break_duration' => 60,
                    'total_hours' => 8.00,
                    'planned_hours' => 8.00,
                    'overtime_hours' => 0.00,
                    'comment' => 'Retour au travail',
                ],
            ];

            foreach ($entries3 as $entry) {
                TimesheetEntry::create($entry);
            }
        }
    }
}
