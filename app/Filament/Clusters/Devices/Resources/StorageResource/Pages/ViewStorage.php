<?php

namespace App\Filament\Clusters\Devices\Resources\StorageResource\Pages;

use App\Filament\Clusters\Devices\Resources\StorageResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewStorage extends ViewRecord
{
    protected static string $resource = StorageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
