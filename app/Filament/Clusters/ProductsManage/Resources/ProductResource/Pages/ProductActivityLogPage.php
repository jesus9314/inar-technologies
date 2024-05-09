<?php

namespace App\Filament\Clusters\ProductsManage\Resources\ProductResource\Pages;

use App\Filament\Clusters\ProductsManage\Resources\ProductResource;
use pxlrbt\FilamentActivityLog\Pages\ListActivities;

class ProductActivityLogPage extends ListActivities
{
    protected static string $resource = ProductResource::class;
}
