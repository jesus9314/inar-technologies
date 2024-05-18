<?php

namespace App\Filament\Clusters\Codes\Resources;

use App\Filament\Clusters\Codes;
use App\Filament\Clusters\Codes\Resources\RamFormFactorResource\Pages;
use App\Filament\Clusters\Codes\Resources\RamFormFactorResource\Pages\RamFormFactorActivityLogPage;
use App\Filament\Clusters\Codes\Resources\RamFormFactorResource\RelationManagers;
use App\Models\RamFormFactor;
use App\Traits\Tables\TraitTables;
use App\Traits\TraitForms;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RamFormFactorResource extends Resource
{
    use TraitForms, TraitTables;

    protected static ?string $model = RamFormFactor::class;

    protected static ?string $navigationIcon = 'heroicon-o-code-bracket-square';

    protected static ?string $navigationLabel = 'Factores de Memorias Ram';

    protected static ?string $modelLabel = 'Factor de Memorias Ram';

    protected static ?string $pluralModelLabel = 'Factores de Memorias Ram';

    protected static ?string $cluster = Codes::class;

    public static function form(Form $form): Form
    {
        return self::ram_form_factor_form($form);
    }

    public static function table(Table $table): Table
    {
        return self::ram_form_factor_table($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageRamFormFactors::route('/'),
            'activities' => RamFormFactorActivityLogPage::route('/{record}/activities'),
        ];
    }
}
