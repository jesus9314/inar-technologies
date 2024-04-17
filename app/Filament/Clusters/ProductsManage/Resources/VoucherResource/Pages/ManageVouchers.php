<?php

namespace App\Filament\Clusters\ProductsManage\Resources\VoucherResource\Pages;

use App\Filament\Clusters\ProductsManage\Resources\VoucherResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageVouchers extends ManageRecords
{
    protected static string $resource = VoucherResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
