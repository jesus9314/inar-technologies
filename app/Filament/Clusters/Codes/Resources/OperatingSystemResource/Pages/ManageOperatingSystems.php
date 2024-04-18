<?php

namespace App\Filament\Clusters\Codes\Resources\OperatingSystemResource\Pages;

use App\Filament\Clusters\Codes\Resources\OperatingSystemResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageOperatingSystems extends ManageRecords
{
    protected static string $resource = OperatingSystemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
