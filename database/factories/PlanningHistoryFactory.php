<?php

namespace Database\Factories;

use App\Models\PlanningAssignment;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PlanningHistory>
 */
class PlanningHistoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'planning_assignment_id' => PlanningAssignment::factory(),
            'old_status' => fake()->randomElement(['en attente', 'validé', 'suspendu', 'terminé']),
            'new_status' => fake()->randomElement(['en attente', 'validé', 'suspendu', 'terminé']),
            'changed_by' => User::factory(),
            'reason' => fake()->sentence(10),
        ];
    }
}
