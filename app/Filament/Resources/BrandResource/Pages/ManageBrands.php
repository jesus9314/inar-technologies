<?php

namespace App\Filament\Resources\BrandResource\Pages;

use App\Filament\Exports\BrandExporter;
use App\Filament\Imports\BrandImporter;
use App\Filament\Resources\BrandResource;
use Filament\Actions;
use Filament\Actions\ExportAction;
use Filament\Actions\ImportAction;
use Filament\Resources\Pages\ManageRecords;

class ManageBrands extends ManageRecords
{
    protected static string $resource = BrandResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->icon('heroicon-s-plus-circle'),
            ExportAction::make()
                ->icon('heroicon-o-arrow-down-tray')
                ->color('warning')
                ->exporter(BrandExporter::class),
            ImportAction::make()
                ->color('success')
                ->icon('heroicon-s-cloud-arrow-up')
                ->slideOver()
                ->importer(BrandImporter::class)
        ];
    }
}
