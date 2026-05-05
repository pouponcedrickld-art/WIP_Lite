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
            ['name' => 'Développeur Senior', 'code' => 'DEV_SR'],
            ['name' => 'Développeur Junior', 'code' => 'DEV_JR'],
            ['name' => 'Chef de Projet', 'code' => 'CP'],
            ['name' => 'Superviseur', 'code' => 'SUP'],
            ['name' => 'Technicien', 'code' => 'TECH'],
            ['name' => 'Manager', 'code' => 'MGR'],
            ['name' => 'Analyste', 'code' => 'ANA'],
            ['name' => 'Designer', 'code' => 'DES'],
        ];
        
        $position = fake()->unique()->randomElement($positions);
        
        return [
            'name' => $position['name'],
            'code' => $position['code'],
            'description' => fake()->sentence(10),
        ];
    }
}
