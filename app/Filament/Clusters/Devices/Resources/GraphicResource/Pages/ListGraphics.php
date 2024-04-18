<?php

namespace App\Filament\Clusters\Devices\Resources\GraphicResource\Pages;

use App\Filament\Clusters\Devices\Resources\GraphicResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListGraphics extends ListRecords
{
    protected static string $resource = GraphicResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
