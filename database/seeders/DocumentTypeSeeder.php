<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DocumentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            [
                'name' => 'Reporte de Mantenimiento de Computadoras',
                'sufijo' => 'RMC',
                'description' => 'Reporte de mantenimiento de computadoras'
            ],
            [
                'name' => 'Acta de Recepción de Dispositivo para Mantenimiento',
                'sufijo' => 'ARDM',
                'description' => 'Acta de recepción de dispositivo para mantenimiento'
            ],
            [
                'name' => 'Comprobante de Garantía de servicio de Mantenimiento',
                'sufijo' => 'CGSM',
                'description' => 'Comprobante de garantía de servicio de mantenimiento'
            ],
        ];

        foreach ($types as $type) {
            \App\Models\DocumentType::create([
                'name' => $type['name'],
                'sufijo' => $type['sufijo'],
                'description' => $type['description']
            ]);
        }
    }
}
