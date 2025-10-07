<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ResumeAccess>
 */
class ResumeAccessFactory extends Factory
{
    protected static ?string $key;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'access_key' => static::$key ??= Hash::make('access_key'),
        ];
    }
}
