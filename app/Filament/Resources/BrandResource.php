<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BrandResource\Pages;
use App\Models\Brand;
use App\Traits\Forms\TraitForms;
use App\Traits\Tables\TraitTables;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;

class BrandResource extends Resource
{
    use TraitForms, TraitTables;

    protected static ?string $model = Brand::class;

    protected static ?string $navigationIcon = 'heroicon-o-film';

    protected static ?string $navigationGroup = 'Productos y Servicios';

    protected static ?string $modelLabel = 'Marca';

    protected static ?string $pluralModelLabel = 'Marcas';

    public static function form(Form $form): Form
    {
        return self::brand_form($form);
    }

    public static function table(Table $table): Table
    {
        // $AuthUser = User::find(auth()->user()->id);

        return self::brand_table($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageBrands::route('/'),
            'activities' => Pages\ActivityLogBrandPage::route('/{record}/activities'),
        ];
    }
}
