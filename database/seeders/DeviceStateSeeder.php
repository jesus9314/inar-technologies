<?php

namespace Database\Seeders;

use App\Models\DeviceState;
use App\Models\DeviceStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DeviceStateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = [
            'Pendiente de Revisión',
            'En Diagnóstico',
            'En Espera de Repuestos',
            'En Reparación',
            'Reparado',
            'En Pruebas',
            'Listo para Entregar',
            'Entregado',
            'No Reparado',
            'En Almacenamiento',
            'Desechado'
        ];

        foreach ($statuses as $status) {
            DeviceState::create(['name' => $status]);
        }
    }
}
