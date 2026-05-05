<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\PlanningModel;
use App\Models\Employee;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PlanningAssignment>
 */
class PlanningAssignmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startDate = fake()->dateTimeBetween('-6 months', '+1 month');
        $endDate = fake()->dateTimeBetween($startDate, '+1 year');
        
        return [
            'planning_model_id' => PlanningModel::factory(),
            'employee_id' => Employee::factory(),
            'start_date' => $startDate->format('Y-m-d'),
            'end_date' => fake()->randomElement([null, $endDate->format('Y-m-d')]),
            'status' => fake()->randomElement(['en attente', 'validé', 'suspendu', 'terminé']),
            'validated_by' => Employee::inRandomOrder()->first()->id,
            'validated_at' => fake()->randomElement([null, fake()->dateTime()]),
        ];
    }
}
