<?php

namespace App\Filament\Clusters\Codes\Resources\ProcessorManufacturerResource\Pages;

use App\Filament\Clusters\Codes\Resources\ProcessorManufacturerResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageProcessorManufacturers extends ManageRecords
{
    protected static string $resource = ProcessorManufacturerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
