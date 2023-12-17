<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Currency;
use App\Models\Payment;
use Illuminate\Database\Seeder;

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

        Payment::factory(20)->create();
    }
}
