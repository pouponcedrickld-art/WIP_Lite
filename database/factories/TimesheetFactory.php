<?php

namespace Database\Factories;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;

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
        $periodStart = fake()->dateTimeBetween('-3 months', '-1 week');
        $periodEnd = (clone $periodStart)->modify('+6 days');
        
        return [
            'employee_id' => Employee::factory(),
            'period_start' => $periodStart->format('Y-m-d'),
            'period_end' => $periodEnd->format('Y-m-d'),
            'status' => fake()->randomElement(['brouillon', 'soumis', 'validé']),
            'validated_by' => Employee::factory(),
            'validated_at' => fake()->optional(0.6)->dateTime(),
        ];
    }
}
