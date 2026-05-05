<?php

namespace Database\Factories;

use App\Models\Campaign;
use App\Models\Employee;
use App\Models\Position;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Assignment>
 */
class AssignmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startDate = fake()->dateTimeBetween('-6 months', '+1 month');
        $endDate = fake()->dateTimeBetween($startDate, '+6 months');
        
        return [
            'employee_id' => Employee::factory(),
            'campaign_id' => Campaign::factory(),
            'manager_id' => Employee::factory(),
            'position_id' => Position::factory(),
            'status' => fake()->randomElement(['actif', 'inactif', 'terminé']),
            'start_date' => $startDate->format('Y-m-d'),
            'end_date' => $endDate->format('Y-m-d'),
        ];
    }
}
