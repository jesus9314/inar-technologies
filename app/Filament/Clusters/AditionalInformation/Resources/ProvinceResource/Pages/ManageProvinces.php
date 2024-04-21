<?php

namespace App\Filament\Clusters\AditionalInformation\Resources\ProvinceResource\Pages;

use App\Filament\Clusters\AditionalInformation\Resources\ProvinceResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageProvinces extends ManageRecords
{
    protected static string $resource = ProvinceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
