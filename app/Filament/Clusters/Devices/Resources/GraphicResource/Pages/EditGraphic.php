<?php

namespace App\Filament\Clusters\Devices\Resources\GraphicResource\Pages;

use App\Filament\Clusters\Devices\Resources\GraphicResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditGraphic extends EditRecord
{
    protected static string $resource = GraphicResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
