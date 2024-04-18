<?php

namespace App\Filament\Clusters\Codes\Resources\MemoryTypeResource\Pages;

use App\Filament\Clusters\Codes\Resources\MemoryTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageMemoryTypes extends ManageRecords
{
    protected static string $resource = MemoryTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
