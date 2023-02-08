<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => fake()->firstName . ' ' . fake()->lastName,
            'email' => fake()->unique()->safeEmail(),
            'card_number' => fake()->unique()->creditCardNumber,
            'password' => 'password',
        ];
    }
}
