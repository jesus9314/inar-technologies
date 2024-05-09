<?php

namespace App\Filament\Clusters\Codes\Resources\CurrencyResource\Pages;

use App\Filament\Clusters\Codes\Resources\CurrencyResource;
use App\Filament\Exports\CurrencyExporter;
use App\Filament\Imports\CurrencyImporter;
use Filament\Actions\CreateAction;
use Filament\Actions\ExportAction;
use Filament\Actions\ImportAction;
use Filament\Resources\Pages\ManageRecords;

class ManageCurrencies extends ManageRecords
{
    protected static string $resource = CurrencyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->icon('heroicon-s-plus-circle'),
            ExportAction::make()
                ->icon('heroicon-o-arrow-down-tray')
                ->color('warning')
                ->exporter(CurrencyExporter::class),
            ImportAction::make()
                ->color('success')
                ->icon('heroicon-s-cloud-arrow-up')
                ->slideOver()
                ->importer(CurrencyImporter::class)
        ];
    }
}
