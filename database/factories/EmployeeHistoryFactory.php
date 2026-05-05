<?php

namespace Database\Factories;

use App\Models\Employee;
use App\Models\Position;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EmployeeHistory>
 */
class EmployeeHistoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'employee_id' => Employee::factory(),
            'old_position_id' => Position::factory(),
            'new_position_id' => Position::factory(),
            'old_status' => fake()->randomElement(['actif', 'inactif', 'suspendu']),
            'new_status' => fake()->randomElement(['actif', 'inactif', 'suspendu']),
            'changed_by' => User::factory(),
            'reason' => fake()->sentence(10),
        ];
    }
}
