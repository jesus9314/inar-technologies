<?php

namespace App\Filament\Clusters\Codes\Resources\GraphicSufixResource\Pages;

use App\Filament\Clusters\Codes\Resources\GraphicSufixResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageGraphicSufixes extends ManageRecords
{
    protected static string $resource = GraphicSufixResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
