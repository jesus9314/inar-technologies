<?php

namespace App\Filament\Clusters\Devices\Resources\RamResource\Pages;

use App\Filament\Clusters\Devices\Resources\RamResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewRam extends ViewRecord
{
    protected static string $resource = RamResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
