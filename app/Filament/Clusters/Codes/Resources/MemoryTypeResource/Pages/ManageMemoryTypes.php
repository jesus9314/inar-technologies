<?php

namespace App\Filament\Clusters\Codes\Resources\MemoryTypeResource\Pages;

use App\Filament\Clusters\Codes\Resources\MemoryTypeResource;
use App\Filament\Exports\MemoryTypeExporter;
use App\Filament\Imports\MemoryTypeImporter;
use Filament\Actions;
use Filament\Actions\CreateAction;
use Filament\Actions\ExportAction;
use Filament\Actions\ImportAction;
use Filament\Resources\Pages\ManageRecords;

class ManageMemoryTypes extends ManageRecords
{
    protected static string $resource = MemoryTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->icon('heroicon-s-plus-circle'),
            ExportAction::make()
                ->icon('heroicon-o-arrow-down-tray')
                ->color('warning')
                ->exporter(MemoryTypeExporter::class),
            ImportAction::make()
                ->color('success')
                ->icon('heroicon-s-cloud-arrow-up')
                ->slideOver()
                ->importer(MemoryTypeImporter::class)
        ];
    }
}
