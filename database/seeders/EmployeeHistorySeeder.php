<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\EmployeeHistory;
use App\Models\Employee;
use App\Models\Position;
use App\Models\User;

class EmployeeHistorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $employeeHistories = [
            [
                'employee_id' => Employee::where('matricule', 'EMP0003')->first()->id, // Pierre Durand
                'old_position_id' => Position::where('code', 'DEV_JR')->first()->id,
                'new_position_id' => Position::where('code', 'DEV_SR')->first()->id,
                'old_status' => 'actif',
                'new_status' => 'actif',
                'changed_by' => User::first()->id,
                'reason' => 'Promotion au niveau senior après 3 ans d\'expérience',
            ],
            [
                'employee_id' => Employee::where('matricule', 'EMP0005')->first()->id, // Thomas Bernard
                'old_position_id' => null,
                'new_position_id' => Position::where('code', 'DEV_JR')->first()->id,
                'old_status' => null,
                'new_status' => 'actif',
                'changed_by' => User::first()->id,
                'reason' => 'Nouvel embauche comme développeur junior',
            ],
            [
                'employee_id' => Employee::where('matricule', 'EMP0007')->first()->id, // Nicolas Robert
                'old_position_id' => Position::where('code', 'DEV_JR')->first()->id,
                'new_position_id' => Position::where('code', 'TECH')->first()->id,
                'old_status' => 'actif',
                'new_status' => 'actif',
                'changed_by' => User::first()->id,
                'reason' => 'Changement de carrière vers le support technique',
            ],
            [
                'employee_id' => Employee::where('matricule', 'EMP0006')->first()->id, // Camille Petit
                'old_position_id' => null,
                'new_position_id' => Position::where('code', 'ANA')->first()->id,
                'old_status' => null,
                'new_status' => 'actif',
                'changed_by' => User::first()->id,
                'reason' => 'Recrutement comme analyste fonctionnel',
            ],
            [
                'employee_id' => Employee::where('matricule', 'EMP0008')->first()->id, // Isabelle Dubois
                'old_position_id' => null,
                'new_position_id' => Position::where('code', 'DES')->first()->id,
                'old_status' => null,
                'new_status' => 'actif',
                'changed_by' => User::first()->id,
                'reason' => 'Nouveau designer UI/UX pour l\'équipe',
            ],
        ];

        foreach ($employeeHistories as $employeeHistory) {
            EmployeeHistory::create($employeeHistory);
        }
    }
}
