<?php

namespace App\Filament\Clusters\Codes\Resources\DeviceTypeResource\Pages;

use App\Filament\Clusters\Codes\Resources\DeviceTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageDeviceTypes extends ManageRecords
{
    protected static string $resource = DeviceTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
