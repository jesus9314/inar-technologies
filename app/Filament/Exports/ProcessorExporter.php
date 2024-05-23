<?php

namespace App\Filament\Exports;

use App\Models\Processor;
use App\Traits\Exports\CustomStyleExportsTrait;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class ProcessorExporter extends Exporter
{
    use CustomStyleExportsTrait;

    protected static ?string $model = Processor::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('name'),
            ExportColumn::make('slug'),
            ExportColumn::make('model'),
            ExportColumn::make('threads'),
            ExportColumn::make('generation'),
            ExportColumn::make('cores'),
            ExportColumn::make('socket'),
            ExportColumn::make('tdp'),
            ExportColumn::make('integrated_graphics'),
            ExportColumn::make('memory_capacity'),
            ExportColumn::make('description'),
            ExportColumn::make('image_url'),
            ExportColumn::make('specifications_url'),
            ExportColumn::make('processorCondition.description'),
            ExportColumn::make('memoryType.description'),
            ExportColumn::make('created_at'),
            ExportColumn::make('updated_at'),
            ExportColumn::make('processorManufacturer.name'),
            ExportColumn::make('processorSerie.name'),
            ExportColumn::make('processorSufix.name'),
            ExportColumn::make('processorGeneration.name'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your processor export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
