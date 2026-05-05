<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PlanningModel>
 */
class PlanningModelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $models = [
            [
                'name' => 'Semaine Standard 40h',
                'monday_hours' => 8,
                'tuesday_hours' => 8,
                'wednesday_hours' => 8,
                'thursday_hours' => 8,
                'friday_hours' => 8,
                'saturday_hours' => 0,
                'sunday_hours' => 0,
                'total_hours' => 40,
            ],
            [
                'name' => 'Semaine 35h',
                'monday_hours' => 7,
                'tuesday_hours' => 7,
                'wednesday_hours' => 7,
                'thursday_hours' => 7,
                'friday_hours' => 7,
                'saturday_hours' => 0,
                'sunday_hours' => 0,
                'total_hours' => 35,
            ],
            [
                'name' => 'Semaine 45h',
                'monday_hours' => 9,
                'tuesday_hours' => 9,
                'wednesday_hours' => 9,
                'thursday_hours' => 9,
                'friday_hours' => 9,
                'saturday_hours' => 0,
                'sunday_hours' => 0,
                'total_hours' => 45,
            ],
            [
                'name' => 'Horaires flexibles',
                'monday_hours' => 8,
                'tuesday_hours' => 8,
                'wednesday_hours' => 8,
                'thursday_hours' => 8,
                'friday_hours' => 8,
                'saturday_hours' => 4,
                'sunday_hours' => 4,
                'total_hours' => 48,
            ],
        ];
        
        $model = fake()->randomElement($models);
        
        return [
            'name' => $model['name'],
            'description' => fake()->sentence(10),
            'monday_hours' => $model['monday_hours'],
            'tuesday_hours' => $model['tuesday_hours'],
            'wednesday_hours' => $model['wednesday_hours'],
            'thursday_hours' => $model['thursday_hours'],
            'friday_hours' => $model['friday_hours'],
            'saturday_hours' => $model['saturday_hours'],
            'sunday_hours' => $model['sunday_hours'],
            'total_hours' => $model['total_hours'],
            'created_by' => User::factory(),
        ];
    }
}
