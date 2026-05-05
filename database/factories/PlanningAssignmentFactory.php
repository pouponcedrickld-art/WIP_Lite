<?php

namespace Database\Factories;

use App\Models\Employee;
use App\Models\PlanningModel;
use Illuminate\Database\Eloquent\Factories\Factory;

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
        $startDate = fake()->dateTimeBetween('-3 months', '+1 month');
        $endDate = fake()->dateTimeBetween($startDate, '+6 months');
        
        return [
            'planning_model_id' => PlanningModel::factory(),
            'employee_id' => Employee::factory(),
            'start_date' => $startDate->format('Y-m-d'),
            'end_date' => $endDate->format('Y-m-d'),
            'status' => fake()->randomElement(['en attente', 'validé', 'suspendu', 'terminé']),
            'validated_by' => Employee::factory(),
            'validated_at' => fake()->optional(0.7)->dateTime(),
        ];
    }
}
