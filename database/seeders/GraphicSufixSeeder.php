<?php

namespace Database\Seeders;

use App\Models\GraphicSufix;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GraphicSufixSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sufixes = [
            //Nvidia
            [
                'name' => 'Ti',
                'description' => 'Indica una versión mejorada del modelo base con mayor rendimiento.',
                'priority' => 1,
                'graphic_manufacturer_id' => 1,
            ],
            [
                'name' => 'Super',
                'description' => 'Indica una versión con mayor eficiencia energética y/o rendimiento ligeramente mejor que el modelo base.',
                'priority' => 1,
                'graphic_manufacturer_id' => 1,
            ],
            [
                'name' => 'FE',
                'description' => 'Indica una tarjeta gráfica "Founders Edition", diseñada y fabricada por NVIDIA.',
                'priority' => 2,
                'graphic_manufacturer_id' => 1,
            ],
            [
                'name' => 'XC',
                'description' => ' Indica una tarjeta gráfica personalizada de un fabricante externo, como EVGA o ASUS.',
                'priority' => 2,
                'graphic_manufacturer_id' => 1,
            ],
            [
                'name' => 'Max-Q',
                'description' => 'Indica una tarjeta gráfica diseñada para portátiles delgados y ligeros, con menor rendimiento y consumo de energía.',
                'priority' => 3,
                'graphic_manufacturer_id' => 1,
            ],
            [
                'name' => 'Mobile',
                'description' => 'Indica una tarjeta gráfica diseñada para portátiles, generalmente con menor rendimiento que las versiones de escritorio.',
                'priority' => 4,
                'graphic_manufacturer_id' => 1,
            ],
            //AMD
            [
                'name' => 'XT',
                'description' => 'Indica una versión de mayor rendimiento del modelo base.',
                'priority' => 1,
                'graphic_manufacturer_id' => 2,
            ],
            [
                'name' => 'XTX',
                'description' => 'Indica la versión de mayor rendimiento de la serie.',
                'priority' => 1,
                'graphic_manufacturer_id' => 2,
            ],
            [
                'name' => 'M',
                'description' => ' Indica una tarjeta gráfica diseñada para portátiles.',
                'priority' => 2,
                'graphic_manufacturer_id' => 2,
            ],
            [
                'name' => 'G',
                'description' => 'Indica una tarjeta gráfica integrada en un procesador AMD.',
                'priority' => 3,
                'graphic_manufacturer_id' => 2,
            ],
            [
                'name' => 'S',
                'description' => 'Indica una versión de bajo consumo de energía.',
                'priority' => 4,
                'graphic_manufacturer_id' => 2,
            ],
            [
                'name' => 'Pro',
                'description' => 'Indica una versión con mayor rendimiento y características adicionales para profesionales.',
                'priority' => 5,
                'graphic_manufacturer_id' => 2,
            ],
        ];

        foreach ($sufixes as $sufix) {
            GraphicSufix::create([
                'name' => $sufix['name'],
                'description' => $sufix['description'],
                'priority' => $sufix['priority'],
                'graphic_manufacturer_id' => $sufix['graphic_manufacturer_id'],
            ]);
        }
    }
}
