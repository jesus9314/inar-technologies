<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\Supplier;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Supplier::factory(10)->create()->each(function($supplier) {
            $country = Country::all()->random();
            $supplier->countries()->attach($country->id);
        });
    }
}
