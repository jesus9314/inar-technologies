<?php

namespace App\Filament\Exports;

use App\Models\Warehouse;
use App\Traits\Exports\CustomStyleExportsTrait;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class WarehouseExporter extends Exporter
{
    use CustomStyleExportsTrait;

    protected static ?string $model = Warehouse::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('description'),
            ExportColumn::make('stablishment'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your warehouse export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
