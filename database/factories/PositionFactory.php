<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Position>
 */
class PositionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $positions = [
            ['name' => 'Ressources Humaines', 'code' => 'RH'],
            ['name' => 'ChefProjet', 'code' => 'CP'],
            ['name' => 'Superviseur', 'code' => 'SUP'],
            ['name' => 'Téléconseiller', 'code' => 'TC'],
        ];
        
        $position = fake()->unique()->randomElement($positions);
        
        return [
            'name' => $position['name'],
            'code' => $position['code'],
            'description' => fake()->sentence(10),
        ];
    }
}
