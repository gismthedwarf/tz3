<?php

namespace Database\Factories;

use App\Models\Currency;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

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
            'creds' => fake()->text(120),
            'sum' => fake()->randomNumber(8),
            'currency_id' => Currency::pluck('id')->random(),
            'user_id' => User::pluck('id')->random(),
        ];
    }
}
