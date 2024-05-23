<?php

namespace App\Filament\Clusters\Devices\Resources\RamResource\Pages;

use App\Filament\Clusters\Devices\Resources\RamResource;
use pxlrbt\FilamentActivityLog\Pages\ListActivities;

class RamActivityLogPage extends ListActivities
{
    protected static string $resource = RamResource::class;
}
