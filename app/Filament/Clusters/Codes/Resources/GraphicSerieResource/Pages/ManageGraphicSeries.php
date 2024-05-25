<?php

namespace App\Filament\Clusters\Codes\Resources\GraphicSerieResource\Pages;

use App\Filament\Clusters\Codes\Resources\GraphicSerieResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageGraphicSeries extends ManageRecords
{
    protected static string $resource = GraphicSerieResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
