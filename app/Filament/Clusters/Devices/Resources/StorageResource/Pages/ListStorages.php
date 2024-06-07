<?php

namespace App\Filament\Clusters\Devices\Resources\StorageResource\Pages;

use App\Filament\Clusters\Devices\Resources\StorageResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListStorages extends ListRecords
{
    protected static string $resource = StorageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
