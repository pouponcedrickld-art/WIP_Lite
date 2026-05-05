<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

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
        $monday = fake()->randomFloat(2, 0, 12);
        $tuesday = fake()->randomFloat(2, 0, 12);
        $wednesday = fake()->randomFloat(2, 0, 12);
        $thursday = fake()->randomFloat(2, 0, 12);
        $friday = fake()->randomFloat(2, 0, 12);
        $saturday = fake()->randomFloat(2, 0, 8);
        $sunday = fake()->randomFloat(2, 0, 8);
        
        $total = $monday + $tuesday + $wednesday + $thursday + $friday + $saturday + $sunday;
        
        return [
            'name' => fake()->randomElement(['Semaine Standard 40h', 'Semaine 35h', 'Semaine 45h', 'Horaires flexibles', 'Temps partiel']),
            'description' => fake()->sentence(10),
            'monday_hours' => $monday,
            'tuesday_hours' => $tuesday,
            'wednesday_hours' => $wednesday,
            'thursday_hours' => $thursday,
            'friday_hours' => $friday,
            'saturday_hours' => $saturday,
            'sunday_hours' => $sunday,
            'total_hours' => $total,
            'created_by' => User::factory(),
        ];
    }
}
