<?php

namespace Database\Seeders;

use App\Models\DeviceStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DeviceStatusSeeder extends Seeder
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
            DeviceStatus::create(['name' => $status]);
        }
    }
}
