<?php

namespace App\Filament\Clusters\Devices\Resources\MotherboardResource\Pages;

use App\Filament\Clusters\Devices\Resources\MotherboardResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMotherboards extends ListRecords
{
    protected static string $resource = MotherboardResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
