<?php

namespace App\Filament\Clusters\Maintenances\Resources\DocumentTypeResource\Pages;

use App\Filament\Clusters\Maintenances\Resources\DocumentTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageDocumentTypes extends ManageRecords
{
    protected static string $resource = DocumentTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
