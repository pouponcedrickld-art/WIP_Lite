<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Timesheet;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TimesheetEntry>
 */
class TimesheetEntryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $date = fake()->dateTimeBetween('-1 month', 'now');
        $checkIn = fake()->dateTimeBetween($date->format('Y-m-d 08:00:00'), $date->format('Y-m-d 10:00:00'));
        $checkOut = fake()->dateTimeBetween($checkIn, $date->format('Y-m-d 19:00:00'));
        
        return [
            'timesheet_id' => Timesheet::factory(),
            'date' => $date->format('Y-m-d'),
            'check_in' => $checkIn->format('H:i:s'),
            'check_out' => fake()->randomElement([null, $checkOut->format('H:i:s')]),
            'break_duration' => fake()->randomElement([0, 30, 45, 60]),
            'total_hours' => fake()->randomFloat(2, 0, 12),
            'planned_hours' => fake()->randomFloat(2, 6, 8),
            'overtime_hours' => fake()->randomFloat(2, 0, 4),
            'absence_type' => fake()->randomElement([null, 'maladie', 'congé', 'RTT']),
            'comment' => fake()->randomElement([null, fake()->sentence(5)]),
        ];
    }
}
