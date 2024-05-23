<?php

namespace App\Filament\Clusters\Devices\Resources;

use App\Filament\Clusters\Devices;
use App\Filament\Clusters\Devices\Resources\ProcessorResource\Pages;
use App\Filament\Clusters\Devices\Resources\ProcessorResource\Pages\ProcessorActivityLogPage;
use App\Filament\Clusters\Devices\Resources\ProcessorResource\RelationManagers;
use App\Models\Processor;
use App\Traits\Forms\DevicesTraitForms;
use App\Traits\Tables\DeviceTraitTables;
use App\Traits\TraitForms;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class ProcessorResource extends Resource
{
    use DevicesTraitForms, DeviceTraitTables;

    protected static ?string $model = Processor::class;

    protected static ?string $navigationIcon = 'heroicon-s-folder-minus';

    protected static ?string $navigationGroup = 'Componentes';

    protected static ?string $modelLabel = 'procesador';

    protected static ?string $pluralModelLabel = 'procesadores';

    protected static ?string $cluster = Devices::class;

    public static function form(Form $form): Form
    {
        return self::proccessor_form($form);
    }

    public static function table(Table $table): Table
    {
        return self::processor_table($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProcessors::route('/'),
            'create' => Pages\CreateProcessor::route('/create'),
            'view' => Pages\ViewProcessor::route('/{record}'),
            'edit' => Pages\EditProcessor::route('/{record}/edit'),
            'activities' => ProcessorActivityLogPage::route('/{record}/activities'),
        ];
    }
}
