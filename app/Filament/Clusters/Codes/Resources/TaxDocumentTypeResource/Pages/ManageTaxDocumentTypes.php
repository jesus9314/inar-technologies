<?php

namespace App\Filament\Clusters\Codes\Resources\TaxDocumentTypeResource\Pages;

use App\Filament\Clusters\Codes\Resources\TaxDocumentTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageTaxDocumentTypes extends ManageRecords
{
    protected static string $resource = TaxDocumentTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
