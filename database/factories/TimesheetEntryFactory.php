<?php

namespace Database\Factories;

use App\Models\Timesheet;
use Illuminate\Database\Eloquent\Factories\Factory;

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
        $checkIn = fake()->dateTimeBetween('08:00', '10:00');
        $checkOut = fake()->dateTimeBetween('16:00', '19:00');
        $breakDuration = fake()->numberBetween(30, 90);
        
        $checkInTime = new \DateTime($checkIn->format('H:i'));
        $checkOutTime = new \DateTime($checkOut->format('H:i'));
        $totalMinutes = ($checkOutTime->getTimestamp() - $checkInTime->getTimestamp()) / 60 - $breakDuration;
        $totalHours = max(0, $totalMinutes / 60);
        
        $plannedHours = fake()->randomFloat(2, 6, 10);
        $overtimeHours = max(0, $totalHours - $plannedHours);
        
        return [
            'timesheet_id' => Timesheet::factory(),
            'date' => fake()->dateTimeBetween('-2 weeks', 'now')->format('Y-m-d'),
            'check_in' => $checkIn->format('H:i'),
            'check_out' => $checkOut->format('H:i'),
            'break_duration' => $breakDuration,
            'total_hours' => $totalHours,
            'planned_hours' => $plannedHours,
            'overtime_hours' => $overtimeHours,
            'absence_type' => fake()->optional(0.1)->randomElement(['Congé payé', 'Maladie', 'RTT', 'Absence injustifiée']),
            'comment' => fake()->optional(0.3)->sentence(),
        ];
    }
}
