<?php

namespace App\Filament\Clusters\Devices\Resources\RamResource\Pages;

use App\Filament\Clusters\Devices\Resources\RamResource;
use App\Filament\Exports\RamExporter;
use App\Filament\Imports\RamImporter;
use Filament\Actions;
use Filament\Actions\CreateAction;
use Filament\Actions\ExportAction;
use Filament\Actions\ImportAction;
use Filament\Resources\Pages\ListRecords;

class ListRams extends ListRecords
{
    protected static string $resource = RamResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->icon('heroicon-s-plus-circle'),
            ExportAction::make()
                ->icon('heroicon-o-arrow-down-tray')
                ->color('warning')
                ->exporter(RamExporter::class),
            ImportAction::make()
                ->color('success')
                ->icon('heroicon-s-cloud-arrow-up')
                ->slideOver()
                ->importer(RamImporter::class)
        ];
    }
}
