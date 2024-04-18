<?php

namespace Database\Seeders;

use App\Models\RamFormFactor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RamFormFactorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $factors = [
            [
                'description' => 'DIMM'
            ],
            [
                'description' => 'SO-DIMM'
            ]
        ];

        foreach ($factors as $factor) {
            RamFormFactor::create([
                'description' => $factor['description'],
            ]);
        }
    }
}
