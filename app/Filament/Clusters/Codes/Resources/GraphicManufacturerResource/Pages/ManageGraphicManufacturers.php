<?php

namespace App\Filament\Clusters\Codes\Resources\GraphicManufacturerResource\Pages;

use App\Filament\Clusters\Codes\Resources\GraphicManufacturerResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageGraphicManufacturers extends ManageRecords
{
    protected static string $resource = GraphicManufacturerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
