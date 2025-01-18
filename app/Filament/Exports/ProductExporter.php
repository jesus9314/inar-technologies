<?php

namespace App\Filament\Exports;

use App\Models\Product;
use App\Traits\Exports\CustomStyleExportsTrait;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class ProductExporter extends Exporter
{
    use CustomStyleExportsTrait;

    protected static ?string $model = Product::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('name')
                ->label('Nombre'),
            ExportColumn::make('secondary_name')
                ->label('Nombre Secundario'),
            ExportColumn::make('service')
                ->label('Modelo'),
            ExportColumn::make('model')
                ->label('Modelo'),
            ExportColumn::make('bar_code')
                ->label('Código de Barras'),
            ExportColumn::make('internal_code')
                ->label('Código Interno'),
            ExportColumn::make('due_date')
                ->label('Fecha de vencimiento'),
            ExportColumn::make('description')
                ->label('Descripción'),
            ExportColumn::make('stock_initial')
                ->label('Stock Inicial'),
            ExportColumn::make('stock_final')
                ->label('Stock Final'),
            ExportColumn::make('stock_min')
                ->label('Stock Mínimo'),
            ExportColumn::make('unity_price')
                ->label('Precio unitario'),
            ExportColumn::make('affectation.description')
                ->label('Tipo de afectación'),
            ExportColumn::make('category.name')
                ->label('Categoría'),
            ExportColumn::make('brand.name')
                ->label('Marca'),
            ExportColumn::make('currency.description')
                ->label('Moneda'),
            ExportColumn::make('unit.description')
                ->label('Unidad'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'La exportación de su producto ha finalizado y ' . number_format($export->successful_rows) . ' ' . str('filas')->plural($export->successful_rows) . ' han sido exportadas.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('fila')->plural($failedRowsCount) . ' no se pudo exportar.';
        }

        return $body;
    }
}
