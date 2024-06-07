<?php

namespace App\Filament\Clusters\Devices\Resources\StorageResource\Pages;

use App\Filament\Clusters\Devices\Resources\StorageResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditStorage extends EditRecord
{
    protected static string $resource = StorageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
