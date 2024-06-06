<?php

namespace App\Filament\Clusters\Devices\Resources\MotherboardResource\Pages;

use App\Filament\Clusters\Devices\Resources\MotherboardResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewMotherboard extends ViewRecord
{
    protected static string $resource = MotherboardResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
