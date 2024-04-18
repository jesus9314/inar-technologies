<?php

namespace App\Filament\Clusters\Codes\Resources\DeviceStateResource\Pages;

use App\Filament\Clusters\Codes\Resources\DeviceStateResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageDeviceStates extends ManageRecords
{
    protected static string $resource = DeviceStateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
