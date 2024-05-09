<?php

namespace App\Filament\Clusters\ProductsManage\Resources\ProductResource\Pages;

use App\Filament\Clusters\ProductsManage\Resources\ProductResource;
use Filament\Actions;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditProduct extends EditRecord
{
    protected static string $resource = ProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make()
        ];
    }
}
