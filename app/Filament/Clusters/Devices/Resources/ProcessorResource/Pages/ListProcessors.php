<?php

namespace App\Filament\Clusters\Devices\Resources\ProcessorResource\Pages;

use App\Filament\Clusters\Devices\Resources\ProcessorResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProcessors extends ListRecords
{
    protected static string $resource = ProcessorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
