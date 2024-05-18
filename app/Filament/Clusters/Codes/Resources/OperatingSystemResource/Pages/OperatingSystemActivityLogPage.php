<?php

namespace App\Filament\Clusters\Codes\Resources\OperatingSystemResource\Pages;

use App\Filament\Clusters\Codes\Resources\OperatingSystemResource;
use Filament\Resources\Pages\Page;
use pxlrbt\FilamentActivityLog\Pages\ListActivities;

class OperatingSystemActivityLogPage extends ListActivities
{
    protected static string $resource = OperatingSystemResource::class;
}
