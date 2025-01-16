<?php

namespace Database\Seeders;

use App\Models\IssuePriority;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IssuePrioritySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $priorities = [
            [
                'name' => 'Critical',
                'color' => 'red'
            ],
            [
                'name' => 'High',
                'color' => 'Naranja'
            ],
            [
                'name' => 'Medium',
                'color' => 'Amarillo'
            ],
            [
                'name' => 'Low',
                'color' => 'Verde'
            ],
            [
                'name' => 'Trivial',
                'color' => 'Azul claro'
            ]
        ];

        foreach ($priorities as $priority) {
            IssuePriority::create([
                'name' => $priority['name'],
                'color' => $priority['color']
            ]);
        }
    }
}
