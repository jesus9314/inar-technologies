<?php

namespace App\Filament\Clusters\Codes\Resources\IdDocumentResource\Pages;

use App\Filament\Clusters\Codes\Resources\IdDocumentResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageIdDocuments extends ManageRecords
{
    protected static string $resource = IdDocumentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
