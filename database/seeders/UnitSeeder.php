<?php

namespace Database\Seeders;

use App\Models\Unit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $units = [
            [
                "code" => "ZZ",
                "description" => " Servicio",
                "symbol" => " SERV",
                "activity_state_id" => 1
            ],
            [
                "code" => "BX",
                "description" => " Caja",
                "symbol" => " CAJ",
                "activity_state_id" => 1
            ],
            [
                "code" => "GLL",
                "description" => " Galon",
                "symbol" => " GL",
                "activity_state_id" => 1
            ],
            [
                "code" => "GRM",
                "description" => " Gramos",
                "symbol" => " GR",
                "activity_state_id" => 1
            ],
            [
                "code" => "KGM",
                "description" => " Kilos",
                "symbol" => " KG",
                "activity_state_id" => 1
            ],
            [
                "code" => "LTR",
                "description" => " Litro",
                "symbol" => " LT",
                "activity_state_id" => 1
            ],
            [
                "code" => "MTR",
                "description" => " Metro",
                "symbol" => " M",
                "activity_state_id" => 1
            ],
            [
                "code" => "FOT",
                "description" => " Pies",
                "symbol" => " PIE",
                "activity_state_id" => 1
            ],
            [
                "code" => "INH",
                "description" => " Pulgadas",
                "symbol" => " INCH",
                "activity_state_id" => 1
            ],
            [
                "code" => "NIU",
                "description" => " Unidad",
                "symbol" => " UND",
                "activity_state_id" => 1
            ],
            [
                "code" => "YRD",
                "description" => " Yarda",
                "symbol" => " YD",
                "activity_state_id" => 1
            ],
            [
                "code" => "HUR",
                "description" => " Hora",
                "symbol" => " HR",
                "activity_state_id" => 1
            ],
            [
                "code" => "TNE",
                "description" => " Toneladas",
                "symbol" => " TNL",
                "activity_state_id" => 1
            ],
            [
                "code" => "DZN",
                "description" => " Docena",
                "symbol" => " DOC",
                "activity_state_id" => 1
            ],
            [
                "code" => "QD",
                "description" => " Cuarto de docena",
                "symbol" => " 1/4 DOC",
                "activity_state_id" => 1
            ],
            [
                "code" => "PK",
                "description" => " Paquete",
                "symbol" => " PQT",
                "activity_state_id" => 1
            ],
            [
                "code" => "MTQ",
                "description" => " Metro",
                "symbol" => " cúbico\tM3",
                "activity_state_id" => 1
            ]
        ];

        foreach ($units as $unit) {
            Unit::create([
                "code" => $unit['code'],
                "description" => $unit['description'],
                "symbol" => $unit['symbol'],
                "activity_state_id" => $unit['activity_state_id']
            ]);
        }
    }
}
