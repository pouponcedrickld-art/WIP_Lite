<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ActivityLog>
 */
class ActivityLogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $models = ['User', 'Employee', 'Campaign', 'Assignment', 'PlanningModel', 'Timesheet'];
        
        return [
            'user_id' => User::factory(),
            'action' => fake()->randomElement(['create', 'update', 'delete']),
            'model_type' => fake()->randomElement($models),
            'model_id' => fake()->numberBetween(1, 1000),
            'description' => fake()->sentence(),
            'ip_address' => fake()->ipv4(),
        ];
    }
}
