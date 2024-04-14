<?php

namespace Database\Seeders;

use App\Models\IdDocument;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IdDocumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $idDocuments = [
            [
                "code" => "0",
                "description" => " Doc.trib.no.dom.sin.ruc",
                "activity_state_id" => 1
            ],
            [
                "code" => "1",
                "description" => " Doc. Nacional de identidad",
                "activity_state_id" => 1
            ],
            [
                "code" => "4",
                "description" => " Carnet de extranjería",
                "activity_state_id" => 1
            ],
            [
                "code" => "6",
                "description" => " Registro Único de contribuyentes",
                "activity_state_id" => 1
            ],
            [
                "code" => "7",
                "description" => " Pasaporte",
                "activity_state_id" => 1
            ],
            [
                "code" => "A",
                "description" => " Ced. Diplomática de identidad",
                "activity_state_id" => 1
            ],
            [
                "code" => "B",
                "description" => " Documento identidad país residencia-no.d",
                "activity_state_id" => 1
            ],
            [
                "code" => "C",
                "description" => " Tax Identification Number - TIN – Doc Trib PP.NN",
                "activity_state_id" => 1
            ],
            [
                "code" => "D",
                "description" => " Identification Number - IN – Doc Trib PP. JJ",
                "activity_state_id" => 1
            ],
            [
                "code" => "E",
                "description" => " TAM- Tarjeta Andina de Migración",
                "activity_state_id" => 1
            ]
        ];

        foreach ($idDocuments as $idDocument) {
            IdDocument::create([
                'code' => $idDocument['code'],
                'description' => $idDocument['description'],
                'activity_state_id' => $idDocument['activity_state_id']
            ]);
        }
    }
}
