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
                'description' => 'Planning standard avec 8 heures par jour du lundi au vendredi',
                'monday_hours' => 8,
                'tuesday_hours' => 8,
                'wednesday_hours' => 8,
                'thursday_hours' => 8,
                'friday_hours' => 8,
                'saturday_hours' => 0,
                'sunday_hours' => 0,
                'total_hours' => 40,
                'created_by' => User::first()->id,
            ],
            [
                'name' => 'Semaine 35h',
                'description' => 'Planning réduit avec 7 heures par jour du lundi au vendredi',
                'monday_hours' => 7,
                'tuesday_hours' => 7,
                'wednesday_hours' => 7,
                'thursday_hours' => 7,
                'friday_hours' => 7,
                'saturday_hours' => 0,
                'sunday_hours' => 0,
                'total_hours' => 35,
                'created_by' => User::first()->id,
            ],
            [
                'name' => 'Semaine 45h',
                'description' => 'Planning intensif avec 9 heures par jour du lundi au vendredi',
                'monday_hours' => 9,
                'tuesday_hours' => 9,
                'wednesday_hours' => 9,
                'thursday_hours' => 9,
                'friday_hours' => 9,
                'saturday_hours' => 0,
                'sunday_hours' => 0,
                'total_hours' => 45,
                'created_by' => User::first()->id,
            ],
            [
                'name' => 'Horaires flexibles',
                'description' => 'Planning flexible avec travail le samedi',
                'monday_hours' => 8,
                'tuesday_hours' => 8,
                'wednesday_hours' => 8,
                'thursday_hours' => 8,
                'friday_hours' => 8,
                'saturday_hours' => 4,
                'sunday_hours' => 4,
                'total_hours' => 48,
                'created_by' => User::first()->id,
            ],
            [
                'name' => 'Temps partiel 20h',
                'description' => 'Planning temps partiel avec 4 heures par jour',
                'monday_hours' => 4,
                'tuesday_hours' => 4,
                'wednesday_hours' => 4,
                'thursday_hours' => 4,
                'friday_hours' => 4,
                'saturday_hours' => 0,
                'sunday_hours' => 0,
                'total_hours' => 20,
                'created_by' => User::first()->id,
            ],
        ];

        foreach ($planningModels as $planningModel) {
            PlanningModel::create($planningModel);
        }
    }
}
