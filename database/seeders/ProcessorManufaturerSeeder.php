<?php

namespace Database\Seeders;

use App\Models\ProcessorManufacturer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProcessorManufaturerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $manufacurers = [
            [
                'name' => 'Intel',
            ],
            [
                'name' => 'AMD'
            ]
        ];

        foreach ($manufacurers as $manufacurer) {
            ProcessorManufacturer::create([
                'name' => $manufacurer['name']
            ]);
        }
    }
}
