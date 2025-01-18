<?php

namespace App\Filament\Imports;

use App\Models\Product;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class ProductImporter extends Importer
{
    protected static ?string $model = Product::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('name')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('slug')
                ->rules(['max:255']),
            ImportColumn::make('secondary_name')
                ->rules(['max:255']),
            ImportColumn::make('service')
                ->rules(['max:255']),
            ImportColumn::make('model')
                ->rules(['max:255']),
            ImportColumn::make('bar_code')
                ->rules(['max:255']),
            ImportColumn::make('internal_code')
                ->rules(['max:255']),
            ImportColumn::make('due_date')
                ->rules(['date']),
            ImportColumn::make('image_url')
                ->rules(['max:255']),
            ImportColumn::make('description')
                ->rules(['max:255']),
            ImportColumn::make('stock_initial')
                ->requiredMapping()
                ->numeric()
                ->rules(['required', 'integer']),
            ImportColumn::make('stock_final')
                ->numeric()
                ->rules(['integer']),
            ImportColumn::make('stock_min')
                ->numeric()
                ->rules(['integer']),
            ImportColumn::make('unity_price')
                ->requiredMapping()
                ->numeric()
                ->rules(['required', 'integer']),
            ImportColumn::make('affectation')
                ->relationship(),
            ImportColumn::make('category')
                ->relationship(),
            ImportColumn::make('brand')
                ->relationship(),
            ImportColumn::make('currency')
                ->relationship(),
            ImportColumn::make('unit')
                ->relationship(),
            ImportColumn::make('service')
                ->relationship(),
        ];
    }

    public function resolveRecord(): ?Product
    {
        // return Product::firstOrNew([
        //     // Update existing records, matching them by `$this->data['column_name']`
        //     'email' => $this->data['email'],
        // ]);

        return new Product();
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your product import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
