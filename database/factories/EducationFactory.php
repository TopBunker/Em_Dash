<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Education>
 */
class EducationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'institution' => $this->faker->words(6,true),
            'start_date' => $this->faker->date(),
            'end_date' => $this->faker->date(),
            'degree' => $this->faker->randomElement(['Bachelor\'s Degree', 'Diploma', 'Certificate', 'PhD', 'Master\'s Degree'])
        ];
    }
}
