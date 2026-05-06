<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Employee;
use App\Models\Position;
use App\Models\User;

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
            'old_position_id' => Position::inRandomOrder()->first()->id,
            'new_position_id' => Position::inRandomOrder()->first()->id,
            'old_status' => fake()->randomElement([null, 'actif', 'inactif']),
            'new_status' => fake()->randomElement(['actif', 'inactif', 'suspendu']),
            'changed_by' => User::factory(),
            'reason' => fake()->sentence(10),
        ];
    }
}
