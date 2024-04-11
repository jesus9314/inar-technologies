<?php

namespace Database\Seeders;

use App\Models\SupplierType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SupplierTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SupplierType::create([
            'code' => '1',
            'description' => 'interno'
        ]);
        SupplierType::create([
            'code' => '2',
            'description' => 'proveedor'
        ]);
    }
}
