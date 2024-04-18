<?php

namespace App\Filament\Clusters\Devices\Resources\ProcessorResource\Pages;

use App\Filament\Clusters\Devices\Resources\ProcessorResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProcessor extends EditRecord
{
    protected static string $resource = ProcessorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
