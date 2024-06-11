<?php

namespace App\Filament\Clusters\Codes\Resources\DeviceStatusResource\Pages;

use App\Filament\Clusters\Codes\Resources\DeviceStatusResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageDeviceStatuses extends ManageRecords
{
    protected static string $resource = DeviceStatusResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
