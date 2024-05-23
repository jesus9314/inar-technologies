<?php

namespace App\Filament\Clusters\Codes\Resources\ProcessorSufixResource\Pages;

use App\Filament\Clusters\Codes\Resources\ProcessorSufixResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageProcessorSufixes extends ManageRecords
{
    protected static string $resource = ProcessorSufixResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
