<?php

namespace App\Traits\Seeders;

use Database\Seeders\ActionSeeder;
use Database\Seeders\AffectationSeeder;
use Database\Seeders\ApiSeeder;
use Database\Seeders\BrandSeeder;
use Database\Seeders\CategorySeeder;
use Database\Seeders\CountrySeeder;
use Database\Seeders\CurrencySeeder;
use Database\Seeders\DepartmentSeeder;
use Database\Seeders\DeviceTypeSeeder;
use Database\Seeders\DistrictSeeder;
use Database\Seeders\IdDocumentSeeder;
use Database\Seeders\MemoryTypeSeeder;
use Database\Seeders\OperatingSystemSeeder;
use Database\Seeders\PeripheralTypeSeeder;
use Database\Seeders\ProcessorConditionSeeder;
use Database\Seeders\ProvinceSeeder;
use Database\Seeders\RamFormFactorSeeder;
use Database\Seeders\ShieldSeeder;
use Database\Seeders\StateSeeder;
use Database\Seeders\SupplierSeeder;
use Database\Seeders\SupplierTypeSeeder;
use Database\Seeders\TaxDocumentTypeSeeder;
use Database\Seeders\UnitSeeder;
use Database\Seeders\WarehouseSeeder;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;

trait DatabaseSeederTrait
{
    private static function create_all_directories(): void
    {
        $directories = [
            'avatars',
            'purchase-vouchers',
            'brand_logos',
            'categories_img',
        ];

        foreach ($directories as $directory) {
            $directory = "public/$directory";
            Storage::deleteDirectory($directory);
            Storage::makeDirectory($directory);
        }
    }
    /**
     * Primero hay que correr los de producción
     */
    private static function getProductionSeeders(): array
    {
        return [
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
            ShieldSeeder::class,
        ];
    }

    /**
     * Luego los que solo se correrán en local
     */
    private static function getJustLocalSeeders(): array
    {
        return [
            SupplierSeeder::class,
            BrandSeeder::class,
            CategorySeeder::class,
        ];
    }

    /**
     * Se hace merge a ambos arrays para obtener lo que correrá en local
     */
    private static function getAllSeeders(): array
    {
        return array_merge(self::getProductionSeeders(), self::getJustLocalSeeders());
    }

    /**
     * Retorna los seeders de local o producción dependiendo
     * del ambiente donde estemos
     */
    private static function getSeeders(): array
    {
        return App::environment('local') ? self::getAllSeeders() : self::getProductionSeeders();
    }
}
