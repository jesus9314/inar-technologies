<?php

namespace Database\Seeders;

use App\Models\Warehouse;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WarehouseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $wareHouses = [
            [
                'description' => 'Almacén Oficina Principal',
                'stablishment' => 'Oficina Principal'
            ],
        ];

        foreach ($wareHouses as $wareHouse) {
            Warehouse::create([
                'description' => $wareHouse['description'],
                'stablishment' => $wareHouse['stablishment']
            ]);
        }
    }
}
