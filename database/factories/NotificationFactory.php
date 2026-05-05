<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Notification>
 */
class NotificationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $types = ['info', 'warning', 'error', 'success'];
        $notifiableTypes = ['User', 'Employee'];
        
        return [
            'type' => fake()->randomElement($types),
            'notifiable_type' => fake()->randomElement($notifiableTypes),
            'notifiable_id' => fake()->numberBetween(1, 100),
            'data' => [
                'title' => fake()->sentence(4),
                'message' => fake()->sentence(10),
                'action_url' => fake()->optional(0.5)->url(),
            ],
            'read_at' => fake()->optional(0.3)->dateTime(),
        ];
    }
}
