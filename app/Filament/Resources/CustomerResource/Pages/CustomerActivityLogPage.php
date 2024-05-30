<?php

namespace App\Filament\Resources\CustomerResource\Pages;

use App\Filament\Resources\CustomerResource;
use Filament\Resources\Pages\Page;
use pxlrbt\FilamentActivityLog\Pages\ListActivities;

class CustomerActivityLogPage extends ListActivities
{
    protected static string $resource = CustomerResource::class;
}
