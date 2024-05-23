<?php

namespace App\Filament\Imports;

use App\Models\Ram;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class RamImporter extends Importer
{
    protected static ?string $model = Ram::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('name')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('speed')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('capacity')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('latency')
                ->rules(['max:255']),
            ImportColumn::make('description'),
            ImportColumn::make('image_url')
                ->rules(['max:255']),
            ImportColumn::make('specifications_link')
                ->rules(['max:255']),
            ImportColumn::make('brand')
                ->relationship(),
            ImportColumn::make('ramFormFactor')
                ->relationship(),
            ImportColumn::make('memoryType')
                ->relationship(),
        ];
    }

    public function resolveRecord(): ?Ram
    {
        // return Ram::firstOrNew([
        //     // Update existing records, matching them by `$this->data['column_name']`
        //     'email' => $this->data['email'],
        // ]);

        return new Ram();
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your ram import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
