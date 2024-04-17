<?php

namespace App\Filament\Clusters\ProductsManage\Resources\PresentationResource\Pages;

use App\Filament\Clusters\ProductsManage\Resources\PresentationResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManagePresentations extends ManageRecords
{
    protected static string $resource = PresentationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
