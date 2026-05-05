<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Assignment;
use App\Models\Employee;
use App\Models\Campaign;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AssignmentHistory>
 */
class AssignmentHistoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'assignment_id' => Assignment::factory(),
            'employee_id' => Employee::factory(),
            'old_manager_id' => Employee::inRandomOrder()->first()->id,
            'new_manager_id' => Employee::inRandomOrder()->first()->id,
            'old_campaign_id' => Campaign::inRandomOrder()->first()->id,
            'new_campaign_id' => Campaign::inRandomOrder()->first()->id,
            'action_type' => fake()->randomElement(['assign', 'release', 'transfer']),
            'changed_by' => User::factory(),
            'reason' => fake()->sentence(10),
        ];
    }
}
