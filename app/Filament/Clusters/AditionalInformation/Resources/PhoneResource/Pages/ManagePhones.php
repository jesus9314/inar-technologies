<?php

namespace App\Filament\Clusters\AditionalInformation\Resources\PhoneResource\Pages;

use App\Filament\Clusters\AditionalInformation\Resources\PhoneResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManagePhones extends ManageRecords
{
    protected static string $resource = PhoneResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
