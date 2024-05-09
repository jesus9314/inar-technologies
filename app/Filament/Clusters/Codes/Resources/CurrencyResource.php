<?php

namespace App\Filament\Clusters\Codes\Resources;

use App\Filament\Clusters\Codes;
use App\Filament\Clusters\Codes\Resources\CurrencyResource\Pages;
use App\Filament\Clusters\Codes\Resources\CurrencyResource\Pages\CurrencyActivityLogPage;
use App\Filament\Clusters\Codes\Resources\CurrencyResource\RelationManagers;
use App\Models\Currency;
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

class CurrencyResource extends Resource
{
    use TraitForms, TraitTables;

    protected static ?string $model = Currency::class;

    protected static ?string $navigationIcon = 'heroicon-c-currency-dollar';

    protected static ?string $cluster = Codes::class;

    protected static ?string $modelLabel = 'Moneda';

    protected static ?string $pluralModelLabel = 'Monedas';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
    public static function form(Form $form): Form
    {
        return self::currency_form($form);
    }

    public static function table(Table $table): Table
    {
        return self::currency_table($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageCurrencies::route('/'),
            'activities' => CurrencyActivityLogPage::route('/{record}/activities'),
        ];
    }
}
