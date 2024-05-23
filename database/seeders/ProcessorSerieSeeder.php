<?php

namespace Database\Seeders;

use App\Models\ProcessorSerie;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProcessorSerieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $series = [
            //AMD
            [
                'name' => 'Ryzen 3',
                'processor_manufacturer_id' => 2
            ],
            [
                'name' => 'Ryzen 5',
                'processor_manufacturer_id' => 2
            ],
            [
                'name' => 'Ryzen 7',
                'processor_manufacturer_id' => 2
            ],
            [
                'name' => 'Ryzen 9',
                'processor_manufacturer_id' => 2
            ],
            //Intel
            [
                'name' => 'Corei i3',
                'processor_manufacturer_id' => 1
            ],
            [
                'name' => 'Corei i5',
                'processor_manufacturer_id' => 1
            ],
            [
                'name' => 'Corei i7',
                'processor_manufacturer_id' => 1
            ],
            [
                'name' => 'Corei i9',
                'processor_manufacturer_id' => 1
            ],
        ];

        foreach ($series as $serie) {
            ProcessorSerie::create([
                'name' => $serie['name'],
                'processor_manufacturer_id' => $serie['processor_manufacturer_id']
            ]);
        }
    }
}
