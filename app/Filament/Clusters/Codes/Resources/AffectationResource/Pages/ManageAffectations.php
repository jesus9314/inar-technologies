<?php

namespace App\Filament\Clusters\Codes\Resources\AffectationResource\Pages;

use App\Filament\Clusters\Codes\Resources\AffectationResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageAffectations extends ManageRecords
{
    protected static string $resource = AffectationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
