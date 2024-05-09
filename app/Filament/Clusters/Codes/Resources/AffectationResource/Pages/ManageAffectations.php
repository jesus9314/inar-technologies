<?php

namespace App\Filament\Clusters\Codes\Resources\AffectationResource\Pages;

use App\Filament\Clusters\Codes\Resources\AffectationResource;
use App\Filament\Exports\AffectationExporter;
use App\Filament\Imports\AffectationImporter;
use Filament\Actions;
use Filament\Actions\ExportAction;
use Filament\Actions\ImportAction;
use Filament\Resources\Pages\ManageRecords;

class ManageAffectations extends ManageRecords
{
    protected static string $resource = AffectationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            ExportAction::make()
                ->icon('heroicon-o-arrow-down-tray')
                ->color('warning')
                ->exporter(AffectationExporter::class),
            ImportAction::make()
                ->color('success')
                ->icon('heroicon-s-cloud-arrow-up')
                ->slideOver()
                ->importer(AffectationImporter::class)
        ];
    }
}
