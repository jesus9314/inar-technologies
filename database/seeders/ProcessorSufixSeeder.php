<?php

namespace Database\Seeders;

use App\Models\ProcessorSufix;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProcessorSufixSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sufixes = [
            //Intel
            [
                'name' => 'K',
                'description' => 'Desbloqueado para overclocking',
                'processor_manufacturer_id' => '1',
            ],
            [
                'name' => 'F',
                'description' => 'Sin gráficos integrados',
                'processor_manufacturer_id' => '1',
            ],
            [
                'name' => 'T',
                'description' => 'Bajo consumo de energía',
                'processor_manufacturer_id' => '1',
            ],
            [
                'name' => 'HK',
                'description' => 'Alto rendimiento desbloqueado',
                'processor_manufacturer_id' => '1',
            ],
            [
                'name' => 'U',
                'description' => 'Bajo consumo de energía para portátiles',
                'processor_manufacturer_id' => '1',
            ],
            [
                'name' => 'Y',
                'description' => 'Muy bajo consumo de energía para portátiles',
                'processor_manufacturer_id' => '1',
            ],
            [
                'name' => 'XE',
                'description' => 'Edición extrema para computadoras de escritorio de alto rendimiento',
                'processor_manufacturer_id' => '1',
            ],

            //AMD

            [
                'name' => 'X',
                'description' => 'Alto rendimiento',
                'processor_manufacturer_id' => '2',
            ],
            [
                'name' => 'G',
                'description' => 'Gráficos integrados',
                'processor_manufacturer_id' => '2',
            ],
            [
                'name' => 'XT',
                'description' => 'Rendimiento superior dentro de la serie',
                'processor_manufacturer_id' => '2',
            ],
            [
                'name' => 'Pro',
                'description' => 'Optimizado para profesionales',
                'processor_manufacturer_id' => '2',
            ],
            [
                'name' => 'U',
                'description' => 'Bajo consumo de energía',
                'processor_manufacturer_id' => '2',
            ],
            [
                'name' => 'H',
                'description' => 'Alto rendimiento para portátiles',
                'processor_manufacturer_id' => '2',
            ],
            [
                'name' => 'HX',
                'description' => 'Alto rendimiento extremo para portátiles',
                'processor_manufacturer_id' => '2',
            ],

        ];

        foreach ($sufixes as $sufix) {
            ProcessorSufix::create([
                'name' => $sufix['name'],
                'description' => $sufix['description'],
                'processor_manufacturer_id' => $sufix['processor_manufacturer_id']
            ]);
        }
    }
}
