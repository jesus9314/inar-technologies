<?php

namespace App\Filament\Clusters\Devices\Resources\DeviceResource\Pages;

use App\Filament\Clusters\Devices\Resources\DeviceResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateDevice extends CreateRecord
{
    protected static string $resource = DeviceResource::class;
}
