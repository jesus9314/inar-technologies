<?php

namespace App\Filament\Clusters\Devices\Resources\RamResource\Pages;

use App\Filament\Clusters\Devices\Resources\RamResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRam extends EditRecord
{
    protected static string $resource = RamResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
