<?php

namespace App\Filament\Clusters\Codes\Resources\CurrencyResource\Pages;

use App\Filament\Clusters\Codes\Resources\CurrencyResource;
use pxlrbt\FilamentActivityLog\Pages\ListActivities;

class CurrencyActivityLogPage extends ListActivities
{
    protected static string $resource = CurrencyResource::class;
}
