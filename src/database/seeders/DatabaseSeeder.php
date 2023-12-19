<?php

namespace Database\Seeders;

use App\Models\Currency;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $currencies = [
            [
                'title' => 'Российский рубль',
                'code' => 'RUB',
                'symbol' => '₽',
            ],
            [
                'title' => 'Евро',
                'code' => 'EUR',
                'symbol' => '€',
            ],
            [
                'title' => 'Доллар США',
                'code' => 'USD',
                'symbol' => '$',
            ],
        ];

        foreach ($currencies as $currency) {
            Currency::create($currency);
        }

        $user = User::create(
            [
                'name' => 'admin',
                'email' => 'admin@admin.ru',
                'email_verified_at' => now(),
                'password' => Hash::make('changeme'),
                'remember_token' => Str::random(10),
            ]
        );

        $user->createToken('access');

        User::factory(9)->create();

        Payment::factory(25)->create();
    }
}
