<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

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
        $models = ['User', 'Employee', 'Campaign', 'Assignment', 'Timesheet', 'PlanningModel'];
        
        return [
            'user_id' => User::factory(),
            'action' => fake()->randomElement(['create', 'update', 'delete']),
            'model_type' => fake()->randomElement($models),
            'model_id' => fake()->numberBetween(1, 100),
            'description' => fake()->sentence(10),
            'ip_address' => fake()->ipv4(),
        ];
    }
}
