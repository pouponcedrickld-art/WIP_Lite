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
                'employee_id' => Employee::where('matricule', 'EMP0001')->first()->id,
                'old_position_id' => Position::where('code', 'CP')->first()->id,
                'new_position_id' => Position::where('code', 'RH')->first()->id,
                'old_status' => 'actif',
                'new_status' => 'actif',
                'changed_by' => User::first()->id,
                'reason' => 'Promotion aux Ressources Humaines',
            ],
            [
                'employee_id' => Employee::where('matricule', 'EMP0002')->first()->id,
                'old_position_id' => Position::where('code', 'TC')->first()->id,
                'new_position_id' => Position::where('code', 'CP')->first()->id,
                'old_status' => 'actif',
                'new_status' => 'actif',
                'changed_by' => User::first()->id,
                'reason' => 'Évolution vers le poste de ChefProjet',
            ],
            [
                'employee_id' => Employee::where('matricule', 'EMP0003')->first()->id,
                'old_position_id' => Position::where('code', 'TC')->first()->id,
                'new_position_id' => Position::where('code', 'CP')->first()->id,
                'old_status' => 'actif',
                'new_status' => 'actif',
                'changed_by' => User::first()->id,
                'reason' => 'Promotion au poste de ChefProjet après expérience',
            ],
            [
                'employee_id' => Employee::where('matricule', 'EMP0004')->first()->id,
                'old_position_id' => Position::where('code', 'TC')->first()->id,
                'new_position_id' => Position::where('code', 'SUP')->first()->id,
                'old_status' => 'actif',
                'new_status' => 'actif',
                'changed_by' => User::first()->id,
                'reason' => 'Promotion au poste de Superviseur',
            ],
        ];

        foreach ($employeeHistories as $employeeHistory) {
            EmployeeHistory::create($employeeHistory);
        }
    }
}
