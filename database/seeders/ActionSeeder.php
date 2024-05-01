<?php

namespace Database\Seeders;

use App\Models\Action;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ActionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $actions = [
            [
                'description' => 'Nuevo Registro'
            ],
            [
                'description' => 'Compra'
            ],
            [
                'description' => 'Venta'
            ],
            [
                'description' => 'Ajuste'
            ],

        ];

        foreach ($actions as $action) {
            Action::create([
                'description' => $action['description']
            ]);
        }
    }
}
