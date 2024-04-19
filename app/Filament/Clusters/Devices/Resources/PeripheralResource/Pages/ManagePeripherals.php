<?php

namespace App\Filament\Clusters\Devices\Resources\PeripheralResource\Pages;

use App\Filament\Clusters\Devices\Resources\PeripheralResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManagePeripherals extends ManageRecords
{
    protected static string $resource = PeripheralResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
