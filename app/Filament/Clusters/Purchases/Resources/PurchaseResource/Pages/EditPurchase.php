<?php

namespace App\Filament\Clusters\Purchases\Resources\PurchaseResource\Pages;

use App\Filament\Clusters\Purchases\Resources\PurchaseResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPurchase extends EditRecord
{
    protected static string $resource = PurchaseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
