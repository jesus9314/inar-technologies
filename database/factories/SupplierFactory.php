<?php

namespace Database\Factories;

use App\Models\Document;
use App\Models\IdDocument;
use App\Models\SupplierType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Supplier>
 */
class SupplierFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $document = IdDocument::all()->random();
        $supplier_type = SupplierType::all()->random();
        // if ($document->description == 'dni'){
        //     $document_number = fake()->randomElements(['334', '455']);
        // }else{
        //     $document_number = fake()->randomElements(['209', '206']);
        // }
        return [
            'name' => fake()->word(),
            'comercial_name' => fake()->word(),
            'document_number' =>  '20479394551',
            'id_document_id' => $document->id,
            'supplier_type_id' => $supplier_type->id,
        ];
    }
}
