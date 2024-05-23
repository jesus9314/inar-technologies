<?php

namespace App\Filament\Imports;

use App\Models\Processor;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class ProcessorImporter extends Importer
{
    protected static ?string $model = Processor::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('name')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('slug')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('auto_name')
                ->requiredMapping()
                ->boolean()
                ->rules(['required', 'boolean']),
            ImportColumn::make('model')
                ->rules(['max:255']),
            ImportColumn::make('threads')
                ->rules(['max:255']),
            ImportColumn::make('generation')
                ->rules(['max:255']),
            ImportColumn::make('cores')
                ->rules(['max:255']),
            ImportColumn::make('socket')
                ->rules(['max:255']),
            ImportColumn::make('tdp')
                ->rules(['max:255']),
            ImportColumn::make('integrated_graphics')
                ->rules(['max:255']),
            ImportColumn::make('memory_capacity')
                ->rules(['max:255']),
            ImportColumn::make('description'),
            ImportColumn::make('image_url')
                ->rules(['max:255']),
            ImportColumn::make('specifications_url')
                ->rules(['max:255']),
            ImportColumn::make('processorCondition')
                ->relationship(),
            ImportColumn::make('memoryType')
                ->relationship(),
            ImportColumn::make('processorManufacturer')
                ->relationship(),
            ImportColumn::make('processorSerie')
                ->relationship(),
            ImportColumn::make('processorSufix')
                ->relationship(),
            ImportColumn::make('processorGeneration')
                ->relationship(),
        ];
    }

    public function resolveRecord(): ?Processor
    {
        // return Processor::firstOrNew([
        //     // Update existing records, matching them by `$this->data['column_name']`
        //     'email' => $this->data['email'],
        // ]);

        return new Processor();
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your processor import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
