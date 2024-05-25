<?php

namespace Database\Seeders;

use App\Models\PeripheralType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PeripheralTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            [
                'name' => 'Estabilizador'
            ],
            [
                'name' => 'Teclado'
            ],
            [
                'name' => 'Mouse'
            ],
            [
                'name' => 'Pantalla'
            ],
            [
                'name' => 'Impresora'
            ],
            [
                'name' => 'Parlantes'
            ],
            [
                'name' => 'Audifonos'
            ],
            [
                'name' => 'Micrófono'
            ],
            [
                'name' => 'Webcam'
            ],
            [
                'name' => 'Hub USB'
            ],
        ];

        foreach ($types as $type) {
            PeripheralType::create([
                'name' => $type['name'],
            ]);
        }
    }
}
