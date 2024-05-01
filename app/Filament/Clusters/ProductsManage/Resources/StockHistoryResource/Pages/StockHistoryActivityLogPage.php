<?php

namespace App\Filament\Clusters\ProductsManage\Resources\StockHistoryResource\Pages;

use App\Filament\Clusters\ProductsManage\Resources\StockHistoryResource;
use Filament\Resources\Pages\Page;
use pxlrbt\FilamentActivityLog\Pages\ListActivities;

class StockHistoryActivityLogPage extends ListActivities
{
    protected static string $resource = StockHistoryResource::class;
}
