<?php

namespace App\Filament\Clusters\Devices\Resources\DeviceResource\Pages;

use App\Filament\Clusters\Devices\Resources\DeviceResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDevices extends ListRecords
{
    protected static string $resource = DeviceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
