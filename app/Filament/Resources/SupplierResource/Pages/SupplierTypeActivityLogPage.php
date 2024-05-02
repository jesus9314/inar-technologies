<?php

namespace App\Filament\Resources\SupplierResource\Pages;

use App\Filament\Resources\SupplierResource;
use Filament\Resources\Pages\Page;
use pxlrbt\FilamentActivityLog\Pages\ListActivities;

class SupplierTypeActivityLogPage extends ListActivities
{
    protected static string $resource = SupplierResource::class;
}
