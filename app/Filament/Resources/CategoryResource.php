<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Filament\Resources\CategoryResource\Pages\CategoryActivityLogPage;
use App\Filament\Resources\CategoryResource\RelationManagers;
use App\Models\Category;
use App\Traits\Forms\TraitForms;
use App\Traits\Tables\TraitTables;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CategoryResource extends Resource
{
    use TraitForms, TraitTables;

    protected static ?string $model = Category::class;

    protected static ?string $navigationIcon = 'heroicon-m-sparkles';

    protected static ?string $navigationGroup = 'Productos y Servicios';

    protected static ?string $modelLabel = 'Categoría';

    protected static ?string $pluralModelLabel = 'Categorías';

    public static function form(Form $form): Form
    {
        return self::category_form($form);
    }

    public static function table(Table $table): Table
    {
        return self::category_table($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageCategories::route('/'),
            'activities' => CategoryActivityLogPage::route('/{record}/activities'),
        ];
    }
}
