<?php

namespace App\Filament\Clusters\Devices\Resources;

use App\Filament\Clusters\Devices;
use App\Filament\Clusters\Devices\Resources\RamResource\Pages;
use App\Filament\Clusters\Devices\Resources\RamResource\Pages\RamActivityLogPage;
use App\Filament\Clusters\Devices\Resources\RamResource\RelationManagers;
use App\Models\Ram;
use App\Traits\Forms\DevicesTraitForms;
use App\Traits\Tables\DeviceTraitTables;
use App\Traits\TraitForms;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RamResource extends Resource
{
    use DevicesTraitForms, DeviceTraitTables;

    protected static ?string $model = Ram::class;

    protected static ?string $navigationIcon = 'heroicon-c-home-modern';

    protected static ?string $navigationGroup = 'Componentes';

    protected static ?string $navigationLabel = 'Memorias Ram';

    protected static ?string $modelLabel = 'Memoria Ram';

    protected static ?string $pluralModelLabel = 'Memorias Ram';

    protected static ?string $cluster = Devices::class;

    public static function form(Form $form): Form
    {
        return self::ram_form($form);
    }

    public static function table(Table $table): Table
    {
        return self::ram_table($table);
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
            'index' => Pages\ListRams::route('/'),
            'activities' => RamActivityLogPage::route('/{record}/activities'),
            // 'create' => Pages\CreateRam::route('/create'),
            // 'view' => Pages\ViewRam::route('/{record}'),
            // 'edit' => Pages\EditRam::route('/{record}/edit'),
        ];
    }
}
