<?php

namespace App\Filament\Resources\ActivityStateResource\Pages;

use App\Filament\Resources\ActivityStateResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageActivityStates extends ManageRecords
{
    protected static string $resource = ActivityStateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
