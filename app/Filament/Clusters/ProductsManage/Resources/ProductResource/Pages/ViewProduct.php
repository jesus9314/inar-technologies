<?php

namespace App\Filament\Clusters\ProductsManage\Resources\ProductResource\Pages;

use App\Filament\Clusters\ProductsManage\Resources\ProductResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewProduct extends ViewRecord
{
    protected static string $resource = ProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
