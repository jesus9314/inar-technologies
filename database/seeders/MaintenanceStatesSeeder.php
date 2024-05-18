<?php

namespace Database\Seeders;

use App\Models\MaintenanceState;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MaintenanceStatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $states = [
            //Mantenimiento
            [
                'name' => 'Pendiente',
                'type' => 'maintenance',
                'color' => 'info'
            ],
            [
                'name' => 'En curso',
                'type' => 'maintenance',
                'color' => 'warning'
            ],
            [
                'name' => 'Finalizado',
                'type' => 'maintenance',
                'color' => 'success'
            ],
            [
                'name' => 'Cancelado',
                'type' => 'maintenance',
                'color' => 'gray'
            ],
            [
                'name' => 'Fallido',
                'type' => 'maintenance',
                'color' => 'danger'
            ],

            //issues
            [
                'name' => 'Abierto',
                'type' => 'issue',
                'color' => 'info'
            ],
            [
                'name' => 'Pendiente',
                'type' => 'issue',
                'color' => 'warning'
            ],
            [
                'name' => 'Resuelto',
                'type' => 'issue',
                'color' => 'gray'
            ],
            [
                'name' => 'Cerrado',
                'type' => 'issue',
                'color' => 'success'
            ]

        ];

        foreach ($states as $state) {
            MaintenanceState::create([
                'name' => $state['name'],
                'type' => $state['type'],
                'color' => $state['color']
            ]);
        }
    }
}
