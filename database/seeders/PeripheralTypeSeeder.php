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
                'description' => 'Teclado'
            ],
            [
                'description' => 'Mouse'
            ],
            [
                'description' => 'Pantalla'
            ],
            [
                'description' => 'Impresora'
            ],
            [
                'description' => 'Parlantes'
            ],
            [
                'description' => 'Audifonos'
            ],
            [
                'description' => 'Micrófono'
            ],
            [
                'description' => 'Webcam'
            ],
            [
                'description' => 'Hub USB'
            ],
        ];

        foreach ($types as $type) {
            PeripheralType::create([
                'description' => $type['description'],
            ]);
        }
    }
}
