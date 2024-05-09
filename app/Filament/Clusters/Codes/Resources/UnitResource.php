<?php

namespace App\Filament\Clusters\Codes\Resources;

use App\Filament\Clusters\Codes;
use App\Filament\Clusters\Codes\Resources\UnitResource\Pages;
use App\Filament\Clusters\Codes\Resources\UnitResource\Pages\UnitActivityPage;
use App\Filament\Clusters\Codes\Resources\UnitResource\RelationManagers;
use App\Models\Unit;
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

class UnitResource extends Resource
{
    use TraitForms, TraitTables;

    protected static ?string $model = Unit::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    protected static ?string $cluster = Codes::class;

    protected static ?string $modelLabel = 'Unidad';

    protected static ?string $pluralModelLabel = 'Unidades';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return self::unit_form($form);
    }

    public static function table(Table $table): Table
    {
        return self::unit_table($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageUnits::route('/'),
            'activities' => UnitActivityPage::route('/{record}/activities'),
        ];
    }
}
