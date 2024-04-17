<?php

namespace App\Filament\Clusters\ProductsManage\Resources\ActionResource\Pages;

use App\Filament\Clusters\ProductsManage\Resources\ActionResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageActions extends ManageRecords
{
    protected static string $resource = ActionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
