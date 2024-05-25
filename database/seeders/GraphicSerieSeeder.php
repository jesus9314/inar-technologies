<?php

namespace Database\Seeders;

use App\Models\GraphicSerie;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GraphicSerieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $series = [
            //Nvidia
            [
                'name' => 'GeForce RTX 40',
                'prefix' => 'GeForce RTX 40',
                'graphic_manufacturer_id' => 1
            ],
            [
                'name' => 'GeForce RTX 30',
                'prefix' => 'GeForce RTX 30',
                'graphic_manufacturer_id' => 1
            ],
            [
                'name' => 'GeForce RTX 20',
                'prefix' => 'GeForce RTX 20',
                'graphic_manufacturer_id' => 1
            ],
            [
                'name' => 'GeForce GTX 10',
                'prefix' => 'GeForce GTX 10',
                'graphic_manufacturer_id' => 1
            ],
            [
                'name' => 'GeForce GTX 9',
                'prefix' => 'GeForce GTX 9',
                'graphic_manufacturer_id' => 1
            ],
            [
                'name' => 'GeForce GTX 7',
                'prefix' => 'GeForce GTX 7',
                'graphic_manufacturer_id' => 1
            ],
            //AMD
            [
                'name' => 'Radeon RX 7000',
                'prefix' => 'Radeon RX 7',
                'graphic_manufacturer_id' => 2
            ],
            [
                'name' => 'Radeon RX 6000',
                'prefix' => 'Radeon RX 6',
                'graphic_manufacturer_id' => 2
            ],
            [
                'name' => 'Radeon RX 5000',
                'prefix' => 'Radeon RX 5',
                'graphic_manufacturer_id' => 2
            ],
            [
                'name' => 'Radeon RX Vega',
                'prefix' => 'Radeon RX Vega',
                'graphic_manufacturer_id' => 2
            ],
            [
                'name' => 'Radeon RX Polaris',
                'prefix' => 'Radeon RX 5',
                'graphic_manufacturer_id' => 2
            ],
            [
                'name' => 'Radeon RX 300',
                'prefix' => 'Radeon RX 3',
                'graphic_manufacturer_id' => 2
            ],
        ];

        foreach ($series as $serie) {
            GraphicSerie::create([
                'name' => $serie['name'],
                'prefix' => $serie['prefix'],
                'graphic_manufacturer_id' => $serie['graphic_manufacturer_id']
            ]);
        }
    }
}
