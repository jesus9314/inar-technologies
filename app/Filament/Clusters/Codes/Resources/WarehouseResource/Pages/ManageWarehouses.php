<?php

namespace App\Filament\Clusters\Codes\Resources\WarehouseResource\Pages;

use App\Filament\Clusters\Codes\Resources\WarehouseResource;
use App\Filament\Exports\WarehouseExporter;
use App\Filament\Imports\WarehouseImporter;
use Filament\Actions\CreateAction;
use Filament\Actions\ExportAction;
use Filament\Actions\ImportAction;
use Filament\Resources\Pages\ManageRecords;

class ManageWarehouses extends ManageRecords
{
    protected static string $resource = WarehouseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->icon('heroicon-s-plus-circle'),
            ExportAction::make()
                ->icon('heroicon-o-arrow-down-tray')
                ->color('warning')
                ->exporter(WarehouseExporter::class),
            ImportAction::make()
                ->color('success')
                ->icon('heroicon-s-cloud-arrow-up')
                ->slideOver()
                ->importer(WarehouseImporter::class)
        ];
    }
}
