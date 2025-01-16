<?php

namespace App\Filament\Clusters\Maintenances\Resources;

use App\Filament\Clusters\Maintenances;
use App\Filament\Clusters\Maintenances\Resources\IssuePriorityResource\Pages;
use App\Filament\Clusters\Maintenances\Resources\IssuePriorityResource\RelationManagers;
use App\Models\IssuePriority;
use App\Traits\Forms\TraitForms;
use App\Traits\Tables\TraitTables;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class IssuePriorityResource extends Resource
{
    use TraitForms, TraitTables;

    protected static ?string $model = IssuePriority::class;

    protected static ?string $navigationIcon = 'heroicon-s-shield-exclamation';

    protected static ?string $cluster = Maintenances::class;

    protected static ?string $navigationGroup = 'Adicional';

    protected static ?string $navigationLabel = 'Prioridad de Incidencias';

    public static function form(Form $form): Form
    {
        return self::issue_priority_form($form);
    }

    public static function table(Table $table): Table
    {
        return self::issue_priority_table($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageIssuePriorities::route('/'),
        ];
    }
}
