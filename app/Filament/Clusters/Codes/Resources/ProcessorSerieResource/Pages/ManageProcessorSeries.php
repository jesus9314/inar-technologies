<?php

namespace App\Filament\Clusters\Codes\Resources\ProcessorSerieResource\Pages;

use App\Filament\Clusters\Codes\Resources\ProcessorSerieResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageProcessorSeries extends ManageRecords
{
    protected static string $resource = ProcessorSerieResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
