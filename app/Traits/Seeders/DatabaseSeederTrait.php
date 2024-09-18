<?php

namespace App\Traits\Seeders;

use Database\Seeders;
use Illuminate\Support\Facades;

trait DatabaseSeederTrait
{
    private static function create_all_directories(): void
    {
        $directories = [
            'avatars',
            'purchase-vouchers',
            'brand_logos',
            'categories_img',
            'operating_system_img',
            'rams_img',
            'processor_img',
            'peripheral_img',
            'graphics_img',
            'snapshots',
        ];

        foreach ($directories as $directory) {
            $directory = "public/$directory";
            Facades\Storage::deleteDirectory($directory);
            Facades\Storage::makeDirectory($directory);
        }
    }
    /**
     * Primero hay que correr los de producción
     */
    private static function getProductionSeeders(): array
    {
        return [
            Seeders\StateSeeder::class,
            Seeders\SupplierTypeSeeder::class,
            Seeders\IdDocumentSeeder::class,
            // Seeders\CountrySeeder::class,
            // Seeders\DepartmentSeeder::class,
            // Seeders\ProvinceSeeder::class,
            // Seeders\DistrictSeeder::class,
            Seeders\AffectationSeeder::class,
            // Seeders\CurrencySeeder::class,
            Seeders\UnitSeeder::class,
            Seeders\WarehouseSeeder::class,
            Seeders\TaxDocumentTypeSeeder::class,
            Seeders\MemoryTypeSeeder::class,
            Seeders\ProcessorConditionSeeder::class,
            Seeders\OperatingSystemSeeder::class,
            Seeders\RamFormFactorSeeder::class,
            Seeders\PeripheralTypeSeeder::class,
            Seeders\DeviceTypeSeeder::class,
            Seeders\ApiSeeder::class,
            Seeders\ActionSeeder::class,
            Seeders\ShieldSeeder::class,
            Seeders\MaintenanceStatesSeeder::class,
            Seeders\ProcessorManufaturerSeeder::class,
            Seeders\ProcessorSerieSeeder::class,
            Seeders\ProcessorSufixSeeder::class,
            Seeders\ProcessorGenerationSeeder::class,
            Seeders\GraphicManufacturerSeeder::class,
            Seeders\GraphicSerieSeeder::class,
            Seeders\GraphicSufixSeeder::class,
            Seeders\DeviceStateSeeder::class,
            // Seeders\CompanySeeder::class,
        ];
    }

    /**
     * Luego los que solo se correrán en local
     */
    private static function getJustLocalSeeders(): array
    {
        return [
            Seeders\SupplierSeeder::class,
            Seeders\BrandSeeder::class,
            // Seeders\CategorySeeder::class,
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
        return Facades\App::environment('local') ? self::getAllSeeders() : self::getProductionSeeders();
    }
}
