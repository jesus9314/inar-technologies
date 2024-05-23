<?php

namespace App\Filament\Clusters\Devices\Resources\ProcessorResource\Pages;

use App\Filament\Clusters\Devices\Resources\ProcessorResource;
use App\Filament\Exports\ProcessorExporter;
use App\Filament\Imports\ProcessorImporter;
use Filament\Actions;
use Filament\Actions\CreateAction;
use Filament\Actions\ExportAction;
use Filament\Actions\ImportAction;
use Filament\Resources\Pages\ListRecords;

class ListProcessors extends ListRecords
{
    protected static string $resource = ProcessorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->icon('heroicon-s-plus-circle'),
            ExportAction::make()
                ->icon('heroicon-o-arrow-down-tray')
                ->color('warning')
                ->exporter(ProcessorExporter::class),
            ImportAction::make()
                ->color('success')
                ->icon('heroicon-s-cloud-arrow-up')
                ->slideOver()
                ->importer(ProcessorImporter::class)
        ];
    }
}
