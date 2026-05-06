<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Timesheet;
use App\Models\Employee;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TimesheetHistory>
 */
class TimesheetHistoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'timesheet_id' => Timesheet::factory(),
            'employee_id' => Employee::factory(),
            'old_status' => fake()->randomElement([null, 'brouillon', 'soumis', 'validé']),
            'new_status' => fake()->randomElement(['brouillon', 'soumis', 'validé']),
            'changed_by' => Employee::factory(),
            'reason' => fake()->sentence(10),
            'created_at' => fake()->dateTime(),
        ];
    }
}
