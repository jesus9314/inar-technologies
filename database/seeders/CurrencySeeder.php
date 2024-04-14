<?php

namespace Database\Seeders;

use App\Models\Currency;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $currencies =
            [
                [
                    'code' => 'PEN',
                    'description' => 'Soles',
                    'symbol' => 'S/',
                    'activity_state_id' => 1
                ],
                [
                    'code' => 'USD',
                    'description' => 'Dólares Americanos',
                    'symbol' => '$',
                    'activity_state_id' => 1
                ],
            ];
            foreach ($currencies as $currency) {
                Currency::create([
                    'code' => $currency['code'],
                    'description' => $currency['description'],
                    'symbol' => $currency['symbol'],
                    'activity_state_id' => $currency['activity_state_id'],
                ]);
            }
    }
}
