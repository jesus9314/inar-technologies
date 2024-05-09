<?php

namespace App\Filament\Exports;

use App\Models\Affectation;
use App\Traits\Exports\CustomStyleExportsTrait;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class AffectationExporter extends Exporter
{
    use CustomStyleExportsTrait;

    protected static ?string $model = Affectation::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('code')
                ->label('Código'),
            ExportColumn::make('description')
                ->label('Descripción'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your affectation export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
