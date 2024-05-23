<?php

namespace App\Filament\Exports;

use App\Models\Ram;
use App\Traits\Exports\CustomStyleExportsTrait;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class RamExporter extends Exporter
{
    use CustomStyleExportsTrait;

    protected static ?string $model = Ram::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('name'),
            ExportColumn::make('speed'),
            ExportColumn::make('capacity'),
            ExportColumn::make('latency'),
            ExportColumn::make('description'),
            ExportColumn::make('image_url'),
            ExportColumn::make('specifications_link'),
            ExportColumn::make('brand.name'),
            ExportColumn::make('ramFormFactor.id'),
            ExportColumn::make('memoryType.id'),
            ExportColumn::make('created_at'),
            ExportColumn::make('updated_at'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your ram export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
