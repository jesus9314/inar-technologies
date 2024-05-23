<?php

namespace App\Filament\Clusters\Codes\Resources\ProcessorGenerationResource\Pages;

use App\Filament\Clusters\Codes\Resources\ProcessorGenerationResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageProcessorGenerations extends ManageRecords
{
    protected static string $resource = ProcessorGenerationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
