<?php

namespace App\Filament\Clusters\Codes\Resources;

use App\Filament\Clusters\Codes;
use App\Filament\Clusters\Codes\Resources\WarehouseResource\Pages;
use App\Filament\Clusters\Codes\Resources\WarehouseResource\Pages\WareHouseActivityLogPage;
use App\Filament\Clusters\Codes\Resources\WarehouseResource\RelationManagers;
use App\Models\Warehouse;
use App\Traits\Forms\TraitForms;
use App\Traits\Tables\TraitTables;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class WarehouseResource extends Resource
{
    use TraitForms, TraitTables;

    protected static ?string $model = Warehouse::class;

    protected static ?string $navigationIcon = 'heroicon-s-wallet';

    protected static ?string $cluster = Codes::class;

    protected static ?string $modelLabel = 'Almacén';

    protected static ?string $pluralModelLabel = 'Almacenes';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return self::warehouse_form($form);
    }

    public static function table(Table $table): Table
    {
        return self::warehouse_table($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageWarehouses::route('/'),
            'activities' => WareHouseActivityLogPage::route('/{record}/activities'),
        ];
    }
}
