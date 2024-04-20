<?php

namespace App\Filament\Clusters\Devices\Resources\DeviceResource\Pages;

use App\Filament\Clusters\Devices\Resources\DeviceResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewDevice extends ViewRecord
{
    protected static string $resource = DeviceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
