<?php

namespace Database\Factories;

use App\Models\Assignment;
use App\Models\Campaign;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

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
            'old_manager_id' => Employee::factory(),
            'new_manager_id' => Employee::factory(),
            'old_campaign_id' => Campaign::factory(),
            'new_campaign_id' => Campaign::factory(),
            'action_type' => fake()->randomElement(['assign', 'release', 'transfer']),
            'changed_by' => User::factory(),
            'reason' => fake()->sentence(10),
        ];
    }
}
