<?php

namespace App\Filament\Clusters\Devices\Resources\PeripheralTypeResource\Pages;

use App\Filament\Clusters\Devices\Resources\PeripheralTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManagePeripheralTypes extends ManageRecords
{
    protected static string $resource = PeripheralTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
