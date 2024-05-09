<?php

namespace App\Filament\Resources\CategoryResource\Pages;

use App\Filament\Exports\CategoryExporter;
use App\Filament\Imports\CategoryImporter;
use App\Filament\Resources\CategoryResource;
use Filament\Actions;
use Filament\Actions\CreateAction;
use Filament\Actions\ExportAction;
use Filament\Actions\ImportAction;
use Filament\Resources\Pages\ManageRecords;

class ManageCategories extends ManageRecords
{
    protected static string $resource = CategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->icon('heroicon-s-plus-circle'),
            ExportAction::make()
                ->icon('heroicon-o-arrow-down-tray')
                ->color('warning')
                ->exporter(CategoryExporter::class),
            ImportAction::make()
                ->color('success')
                ->icon('heroicon-s-cloud-arrow-up')
                ->slideOver()
                ->importer(CategoryImporter::class)

        ];
    }
}
