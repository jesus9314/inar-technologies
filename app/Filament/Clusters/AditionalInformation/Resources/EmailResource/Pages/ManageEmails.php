<?php

namespace App\Filament\Clusters\AditionalInformation\Resources\EmailResource\Pages;

use App\Filament\Clusters\AditionalInformation\Resources\EmailResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageEmails extends ManageRecords
{
    protected static string $resource = EmailResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
