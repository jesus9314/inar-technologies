<?php

namespace Database\Seeders;

use App\Models\TaxDocumentType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TaxDocumentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $taxDocumentTypes = [
            [
                "code" => 1,
                "description" => "Factura",
                "activity_state_id" => 1
            ],
            [
                "code" => 3,
                "description" => "Boleta de venta",
                "activity_state_id" => 1
            ],
            [
                "code" => 6,
                "description" => "Carta de porte aéreo",
                "activity_state_id" => 1
            ],
            [
                "code" => 7,
                "description" => "Nota de crédito",
                "activity_state_id" => 1
            ],
            [
                "code" => 8,
                "description" => "Nota de débito",
                "activity_state_id" => 1
            ],
            [
                "code" => 9,
                "description" => "Guia de remisión remitente",
                "activity_state_id" => 1
            ],
            [
                "code" => 12,
                "description" => "Ticket de maquina registradora",
                "activity_state_id" => 1
            ],
            [
                "code" => 13,
                "description" => "Documento emitido por bancos, instituciones financieras, crediticias y de seguros que se encuentren bajo el control de la superintendencia de banca y seguros",
                "activity_state_id" => 1
            ],
            [
                "code" => 14,
                "description" => "Recibo de servicios públicos",
                "activity_state_id" => 1
            ],
            [
                "code" => 15,
                "description" => "Boletos emitidos por el servicio de transporte terrestre regular urbano de pasajeros y el ferroviario público de pasajeros prestado en vía férrea local.",
                "activity_state_id" => 1
            ],
            [
                "code" => 16,
                "description" => "Boleto de viaje emitido por las empresas de transporte público interprovincial de pasajeros",
                "activity_state_id" => 1
            ],
            [
                "code" => 18,
                "description" => "Documentos emitidos por las afp",
                "activity_state_id" => 1
            ],
            [
                "code" => 20,
                "description" => "Comprobante de retencion",
                "activity_state_id" => 1
            ],
            [
                "code" => 21,
                "description" => "Conocimiento de embarque por el servicio de transporte de carga marítima",
                "activity_state_id" => 1
            ],
            [
                "code" => 24,
                "description" => "Certificado de pago de regalías emitidas por perupetro s.a.",
                "activity_state_id" => 1
            ],
            [
                "code" => 31,
                "description" => "Guía de remisión transportista",
                "activity_state_id" => 1
            ],
            [
                "code" => 37,
                "description" => "Documentos que emitan los concesionarios del servicio de revisiones técnicas",
                "activity_state_id" => 1
            ],
            [
                "code" => 40,
                "description" => "Comprobante de percepción",
                "activity_state_id" => 1
            ],
            [
                "code" => 41,
                "description" => "Comprobante de percepción – venta interna (físico - formato impreso)",
                "activity_state_id" => 1
            ],
            [
                "code" => 43,
                "description" => "Boleto de compañias de aviación transporte aéreo no regular",
                "activity_state_id" => 1
            ],
            [
                "code" => 45,
                "description" => "Documentos emitidos por centros educativos y culturales, universidades, asociaciones y fundaciones.",
                "activity_state_id" => 1
            ],
            [
                "code" => 56,
                "description" => "Comprobante de pago seae",
                "activity_state_id" => 1
            ],
            [
                "code" => 71,
                "description" => "Guia de remisión remitente complementaria",
                "activity_state_id" => 1
            ],
            [
                "code" => 72,
                "description" => "Guia de remisión transportista complementaria",
                "activity_state_id" => 1
            ]
        ];

        foreach ($taxDocumentTypes as $taxDocumentType) {
            TaxDocumentType::create([
                "code" => $taxDocumentType['code'],
                "description" => $taxDocumentType['description'],
                "activity_state_id" => $taxDocumentType['activity_state_id'],
            ]);
        }
    }
}
