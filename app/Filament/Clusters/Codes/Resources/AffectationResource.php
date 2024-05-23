<?php

namespace App\Filament\Clusters\Codes\Resources;

use App\Filament\Clusters\Codes;
use App\Filament\Clusters\Codes\Resources\AffectationResource\Pages;
use App\Filament\Clusters\Codes\Resources\AffectationResource\RelationManagers;
use App\Models\Affectation;
use App\Traits\Tables\TraitTables;
use App\Traits\Forms\TraitForms;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AffectationResource extends Resource
{
    use TraitForms, TraitTables;

    protected static ?string $model = Affectation::class;

    protected static ?string $navigationIcon = 'heroicon-m-code-bracket';

    protected static ?string $cluster = Codes::class;

    protected static ?string $modelLabel = 'Tipo de Afectación al IGV';

    protected static ?string $pluralModelLabel = 'Tipos de Afectación al IGV';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
    public static function form(Form $form): Form
    {
        return self::affectation_form($form);
    }

    public static function table(Table $table): Table
    {
        return self::affectation_table($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageAffectations::route('/'),
        ];
    }
}
