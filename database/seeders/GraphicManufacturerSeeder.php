<?php

namespace Database\Seeders;

use App\Models\GraphicManufacturer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GraphicManufacturerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $manufacturers = [
            [
                'name' => 'NVIDIA',
            ],
            [
                'name' => 'AMD'
            ]
        ];

        foreach ($manufacturers as $manufacturer) {
            GraphicManufacturer::create([
                'name' => $manufacturer['name'],
            ]);
        }
    }
}
