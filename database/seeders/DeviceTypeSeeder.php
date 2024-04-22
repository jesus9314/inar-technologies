<?php

namespace Database\Seeders;

use App\Models\DeviceType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DeviceTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            [
                'description' => 'Escritorio',
                'symbol' => 'Desktop'
            ],
            [
                'description' => 'Computadora Portátil',
                'symbol' => 'Laptop'
            ],
            [
                'description' => 'Tableta',
                'symbol' => 'Tablet'
            ],
        ];

        foreach ($types as $type) {
            DeviceType::create([
                'description' => $type['description'],
                'symbol' => $type['symbol'],
            ]);
        }
    }
}
