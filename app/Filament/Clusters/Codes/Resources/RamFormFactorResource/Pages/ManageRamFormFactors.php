<?php

namespace App\Filament\Clusters\Codes\Resources\RamFormFactorResource\Pages;

use App\Filament\Clusters\Codes\Resources\RamFormFactorResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageRamFormFactors extends ManageRecords
{
    protected static string $resource = RamFormFactorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
