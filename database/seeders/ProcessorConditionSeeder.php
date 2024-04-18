<?php

namespace Database\Seeders;

use App\Models\ProcessorCondition;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProcessorConditionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $processorConditions = [
            [
                'description' => 'Escritorio'
            ],
            [
                'description' => 'Laptop'
            ],
            [
                'description' => 'Celular'
            ],
            [
                'description' => 'Tablet'
            ],
            [
                'description' => 'Smart Watch'
            ],
        ];

        foreach ($processorConditions as $processorCondition) {
            ProcessorCondition::create([
                'description' => $processorCondition['description']
            ]);
        }
    }
}
