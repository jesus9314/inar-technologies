<?php

namespace App\Filament\Clusters\Codes\Resources\ProcessorConditionResource\Pages;

use App\Filament\Clusters\Codes\Resources\ProcessorConditionResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageProcessorConditions extends ManageRecords
{
    protected static string $resource = ProcessorConditionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
