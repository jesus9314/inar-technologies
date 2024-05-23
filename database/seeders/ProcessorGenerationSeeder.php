<?php

namespace Database\Seeders;

use App\Models\ProcessorGeneration;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProcessorGenerationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $generations = [
            //Intel
            [
                'name' => '1ª generación',
                'prefix' => 1,
                'key_name' => 'Nehalem',
                'year' => '2008',
                'processor_manufacturer_id' => 1
            ],
            [
                'name' => '2ª generación',
                'prefix' => 2,
                'key_name' => 'Sandy Bridge',
                'year' => '2011',
                'processor_manufacturer_id' => 1
            ],
            [
                'name' => '3ª generación',
                'prefix' => 3,
                'key_name' => 'Ivy Bridge',
                'year' => '2012',
                'processor_manufacturer_id' => 1
            ],
            [
                'name' => '4ª generación',
                'prefix' => 4,
                'key_name' => 'Haswell',
                'year' => '2013',
                'processor_manufacturer_id' => 1
            ],
            [
                'name' => '5ª generación',
                'prefix' => 5,
                'key_name' => 'Broadwell',
                'year' => '2014',
                'processor_manufacturer_id' => 1
            ],
            [
                'name' => '6ª generación',
                'prefix' => 6,
                'key_name' => 'Skylake',
                'year' => '2015',
                'processor_manufacturer_id' => 1
            ],
            [
                'name' => '7ª generación',
                'prefix' => 7,
                'key_name' => 'Kaby Lake',
                'year' => '2016',
                'processor_manufacturer_id' => 1
            ],
            [
                'name' => '8ª generación',
                'prefix' => 8,
                'key_name' => 'Coffee Lake',
                'year' => '2017',
                'processor_manufacturer_id' => 1
            ],
            [
                'name' => '9ª generación',
                'prefix' => 9,
                'key_name' => 'Coffee Lake Refresh',
                'year' => '2018',
                'processor_manufacturer_id' => 1
            ],
            [
                'name' => '10ª generación',
                'prefix' => 10,
                'key_name' => 'Comet Lake',
                'year' => '2019',
                'processor_manufacturer_id' => 1
            ],
            [
                'name' => '11ª generación',
                'prefix' => 11,
                'key_name' => 'Rocket Lake',
                'year' => '2021',
                'processor_manufacturer_id' => 1
            ],
            [
                'name' => '12ª generación',
                'prefix' => 12,
                'key_name' => 'Alder Lake',
                'year' => '2020',
                'processor_manufacturer_id' => 1
            ],
            [
                'name' => '13ª generación',
                'prefix' => 13,
                'key_name' => 'Alder Lake',
                'year' => '2021',
                'processor_manufacturer_id' => 1
            ],
            [
                'name' => '14ª generación',
                'prefix' => 14,
                'key_name' => 'Raptor Lake',
                'year' => '2022',
                'processor_manufacturer_id' => 1
            ],
            //AMD
            [
                'name' => 'Ryzen 1000',
                'prefix' => 1,
                'key_name' => 'Zen',
                'year' => '2017',
                'processor_manufacturer_id' => 2
            ],
            [
                'name' => 'Ryzen 2000',
                'prefix' => 2,
                'key_name' => 'Zen+',
                'year' => '2018',
                'processor_manufacturer_id' => 2
            ],
            [
                'name' => 'Ryzen 3000',
                'prefix' => 3,
                'key_name' => 'Zen 2',
                'year' => '2019',
                'processor_manufacturer_id' => 2
            ],
            [
                'name' => 'Ryzen 5000',
                'prefix' => 5,
                'key_name' => 'Zen 3',
                'year' => '2020',
                'processor_manufacturer_id' => 2
            ],
            [
                'name' => 'Ryzen 6000',
                'prefix' => 6,
                'key_name' => 'Zen 3+',
                'year' => '2022',
                'processor_manufacturer_id' => 2
            ],
            [
                'name' => 'Ryzen 7000',
                'prefix' => 7,
                'key_name' => 'Zen 4',
                'year' => '2023',
                'processor_manufacturer_id' => 2
            ],
        ];

        foreach ($generations as $generation) {
            ProcessorGeneration::create([
                'name' => $generation['name'],
                'prefix' => $generation['prefix'],
                'key_name' => $generation['key_name'],
                'year' => $generation['year'],
                'processor_manufacturer_id' => $generation['processor_manufacturer_id'],
            ]);
        }
    }
}
