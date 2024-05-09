<?php

namespace App\Filament\Clusters\Codes\Resources\UnitResource\Pages;

use App\Filament\Clusters\Codes\Resources\UnitResource;
use App\Filament\Exports\UnitExporter;
use App\Filament\Imports\UnitImporter;
use Filament\Actions\CreateAction;
use Filament\Actions\ExportAction;
use Filament\Actions\ImportAction;
use Filament\Resources\Pages\ManageRecords;

class ManageUnits extends ManageRecords
{
    protected static string $resource = UnitResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->icon('heroicon-s-plus-circle'),
            ExportAction::make()
                ->icon('heroicon-o-arrow-down-tray')
                ->color('warning')
                ->exporter(UnitExporter::class),
            ImportAction::make()
                ->color('success')
                ->icon('heroicon-s-cloud-arrow-up')
                ->slideOver()
                ->importer(UnitImporter::class)
        ];
    }
}
