<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'heading' => $this->faker->optional(0.5)->randomElement(['title 1', 'title a', 'this is also a title', 'chocolate thunder']),
            'task' => $this->faker->sentence()
        ];
    }
}
