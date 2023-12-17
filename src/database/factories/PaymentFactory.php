<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class PaymentFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'login' => fake()->name(),
            'creds' => fake()->text(40),
            'sum' => fake()->randomNumber(5, false),
            'currency_id' => fake()->randomElement([1, 2, 3]),
        ];
    }
}
