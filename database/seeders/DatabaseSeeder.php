<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

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

        $this->call(self::getSeeders());
    }

    public static function getSeeders(): array
    {
        $seeders = array();

        if (App::environment('local')) {
            $seeders = [
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
                DeviceTypeSeeder::class,
                ApiSeeder::class,
                ActionSeeder::class,

                SupplierSeeder::class,
                BrandSeeder::class,
                CategorySeeder::class,
            ];
        } elseif (App::environment('production')) {
            $seeders = [
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
                DeviceTypeSeeder::class,
                ApiSeeder::class,
                ActionSeeder::class,
            ];
        }
        return $seeders;
    }
}
