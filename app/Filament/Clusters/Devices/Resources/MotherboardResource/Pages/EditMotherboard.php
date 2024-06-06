<?php

namespace App\Filament\Clusters\Devices\Resources\MotherboardResource\Pages;

use App\Filament\Clusters\Devices\Resources\MotherboardResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMotherboard extends EditRecord
{
    protected static string $resource = MotherboardResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
