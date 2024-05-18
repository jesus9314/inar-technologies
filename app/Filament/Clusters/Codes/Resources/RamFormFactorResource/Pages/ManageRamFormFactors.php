<?php

namespace App\Filament\Clusters\Codes\Resources\RamFormFactorResource\Pages;

use App\Filament\Clusters\Codes\Resources\RamFormFactorResource;
use App\Filament\Exports\RamFormFactorExporter;
use App\Filament\Imports\RamFormFactorImporter;
use Filament\Actions;
use Filament\Actions\CreateAction;
use Filament\Actions\ExportAction;
use Filament\Actions\ImportAction;
use Filament\Resources\Pages\ManageRecords;

class ManageRamFormFactors extends ManageRecords
{
    protected static string $resource = RamFormFactorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->icon('heroicon-s-plus-circle'),
            ExportAction::make()
                ->icon('heroicon-o-arrow-down-tray')
                ->color('warning')
                ->exporter(RamFormFactorExporter::class),
            ImportAction::make()
                ->color('success')
                ->icon('heroicon-s-cloud-arrow-up')
                ->slideOver()
                ->importer(RamFormFactorImporter::class)
        ];
    }
}
