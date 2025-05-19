<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class PatientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'full_name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'address' => fake()->address(),
            'gender' => fake()->randomElement([0, 1]),
            'date_of_birth' => fake()->date(),
            'blood_type' => fake()->randomElement(['A', 'B', 'AB', 'O']),
            'allergies' => fake()->text(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

}
