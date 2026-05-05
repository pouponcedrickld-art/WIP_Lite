<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Employee;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Timesheet>
 */
class TimesheetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startDate = fake()->dateTimeBetween('-3 months', '-1 week');
        $endDate = (clone $startDate)->modify('+6 days');
        
        return [
            'employee_id' => Employee::factory(),
            'period_start' => $startDate->format('Y-m-d'),
            'period_end' => $endDate->format('Y-m-d'),
            'status' => fake()->randomElement(['brouillon', 'soumis', 'validé']),
            'validated_by' => Employee::inRandomOrder()->first()->id,
            'validated_at' => fake()->randomElement([null, fake()->dateTime()]),
        ];
    }
}
