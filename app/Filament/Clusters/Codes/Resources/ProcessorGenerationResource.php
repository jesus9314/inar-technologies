<?php

namespace App\Filament\Clusters\Codes\Resources;

use App\Filament\Clusters\Codes;
use App\Filament\Clusters\Codes\Resources\ProcessorGenerationResource\Pages;
use App\Filament\Clusters\Codes\Resources\ProcessorGenerationResource\Pages\ProcessorGenerationActivityLogsPage;
use App\Filament\Clusters\Codes\Resources\ProcessorGenerationResource\RelationManagers;
use App\Models\ProcessorGeneration;
use App\Traits\Forms\DevicesTraitForms;
use App\Traits\Tables\DeviceTraitTables;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProcessorGenerationResource extends Resource
{
    use DevicesTraitForms, DeviceTraitTables;

    protected static ?string $model = ProcessorGeneration::class;

    protected static ?string $navigationIcon = 'heroicon-m-command-line';

    protected static ?string $navigationGroup = 'Procesador';

    protected static ?string $modelLabel = 'Generaciones de procesadores';

    protected static ?string $pluralModelLabel = 'generaciones de procesadores';

    protected static ?string $cluster = Codes::class;

    public static function form(Form $form): Form
    {
        return self::processor_generation_form($form);
    }

    public static function table(Table $table): Table
    {
        return self::processor_generation_table($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageProcessorGenerations::route('/'),
            'activities' => ProcessorGenerationActivityLogsPage::route('/{record}/activities'),
        ];
    }
}
