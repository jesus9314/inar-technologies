<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Jesus Inchicaque',
            'email' => 'jesus.9314@gmail.com',
            'password' => bcrypt('alienado123')
        ]);

        $this->call([
            //production
            StateSeeder::class,
            IdDocumentSeeder::class,
            SupplierTypeSeeder::class,
            CountrySeeder::class,
            DepartmentSeeder::class,
            ProvinceSeeder::class,
            DistrictSeeder::class,
            AffectationSeeder::class,
            CurrencySeeder::class,
            UnitSeeder::class,
            WarehouseSeeder::class,
            TaxDocumentTypeSeeder::class,
            MemoryTypeSeeder::class,
            ProcessorConditionSeeder::class,
            OperatingSystemSeeder::class,
            RamFormFactorSeeder::class,
            PeripheralTypeSeeder::class,

            //no production
            SupplierSeeder::class,
            BrandSeeder::class,
            CategorySeeder::class,
        ]);
    }
}
