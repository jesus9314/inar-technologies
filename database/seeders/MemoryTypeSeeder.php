<?php

namespace Database\Seeders;

use App\Models\MemoryType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MemoryTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $memory_types = [
            [
                'description' => 'SIPP'
            ],
            [
                'description' => 'RAMBUS'
            ],
            [
                'description' => 'DIMM'
            ],
            [
                'description' => 'RIMM'
            ],
            [
                'description' => 'DDR2'
            ],
            [
                'description' => 'DDR3'
            ],
            [
                'description' => 'DDR4'
            ],
            [
                'description' => 'DDR5'
            ],
            [
                'description' => 'VRAM - GDDR5'
            ],
            [
                'description' => 'VRAM - GDDR6'
            ],
            [
                'description' => 'VRAM - HBM'
            ],
        ];

        foreach ($memory_types as $memory_type) {
            MemoryType::create([
                'description' => $memory_type['description'],
            ]);
        }
    }
}
