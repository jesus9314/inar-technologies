<?php

namespace App\Filament\Plugins\CustomFilamentEcommercePlugin\Resources\ProductResource\Pages;

use App\Filament\Plugins\CustomFilamentEcommercePlugin\Resources\ProductResource;
use TomatoPHP\FilamentEcommerce\Filament\Resources\ProductResource\Pages\CreateProduct as BaseCreateProduct;

class CreateProduct extends BaseCreateProduct 
{
    protected static string $resource = ProductResource::class;
    
    public static function getTranslatableLocales(): array
    {
        return ['es'];
    }
}
