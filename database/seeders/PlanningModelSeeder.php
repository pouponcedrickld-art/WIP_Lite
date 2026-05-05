<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PlanningModel;
use App\Models\User;

class PlanningModelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $planningModels = [
            [
                'name' => 'Semaine Standard 40h',
                'description' => 'Planning standard du lundi au vendredi, 8h par jour',
                'monday_hours' => 8.00,
                'tuesday_hours' => 8.00,
                'wednesday_hours' => 8.00,
                'thursday_hours' => 8.00,
                'friday_hours' => 8.00,
                'saturday_hours' => 0.00,
                'sunday_hours' => 0.00,
                'total_hours' => 40.00,
                'created_by' => User::first()->id,
            ],
            [
                'name' => 'Semaine 35h',
                'description' => 'Planning à temps partiel, 7h par jour du lundi au vendredi',
                'monday_hours' => 7.00,
                'tuesday_hours' => 7.00,
                'wednesday_hours' => 7.00,
                'thursday_hours' => 7.00,
                'friday_hours' => 7.00,
                'saturday_hours' => 0.00,
                'sunday_hours' => 0.00,
                'total_hours' => 35.00,
                'created_by' => User::first()->id,
            ],
            [
                'name' => 'Semaine 45h',
                'description' => 'Planning intensif avec heures supplémentaires',
                'monday_hours' => 9.00,
                'tuesday_hours' => 9.00,
                'wednesday_hours' => 9.00,
                'thursday_hours' => 9.00,
                'friday_hours' => 9.00,
                'saturday_hours' => 0.00,
                'sunday_hours' => 0.00,
                'total_hours' => 45.00,
                'created_by' => User::first()->id,
            ],
            [
                'name' => 'Horaires flexibles',
                'description' => 'Planning flexible avec travail le samedi',
                'monday_hours' => 8.00,
                'tuesday_hours' => 8.00,
                'wednesday_hours' => 8.00,
                'thursday_hours' => 8.00,
                'friday_hours' => 6.00,
                'saturday_hours' => 4.00,
                'sunday_hours' => 0.00,
                'total_hours' => 42.00,
                'created_by' => User::first()->id,
            ],
            [
                'name' => 'Temps partiel 20h',
                'description' => 'Planning à temps partiel réduit',
                'monday_hours' => 4.00,
                'tuesday_hours' => 4.00,
                'wednesday_hours' => 4.00,
                'thursday_hours' => 4.00,
                'friday_hours' => 4.00,
                'saturday_hours' => 0.00,
                'sunday_hours' => 0.00,
                'total_hours' => 20.00,
                'created_by' => User::first()->id,
            ],
        ];

        foreach ($planningModels as $planningModel) {
            PlanningModel::create($planningModel);
        }
    }
}
