<?php

namespace App\Filament\Clusters\ProductsManage\Resources;

use App\Filament\Clusters\ProductsManage;
use App\Filament\Clusters\ProductsManage\Resources\ProductResource\Pages;
use App\Filament\Clusters\ProductsManage\Resources\ProductResource\Pages\ProductActivityLogPage;
use App\Models\Product;
use App\Traits\Forms\ProductTraitForms;
use App\Tratis\Tables\ProductTraitTable;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;


class ProductResource extends Resource
{
    use ProductTraitForms, ProductTraitTable;

    protected static ?string $model = Product::class;

    protected static ?string $cluster = ProductsManage::class;

    protected static ?string $navigationIcon = 'heroicon-c-building-storefront';

    protected static ?string $modelLabel = 'Producto';

    protected static ?string $pluralModelLabel = 'Productos';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function form(Form $form): Form
    {
        return self::product_form($form);
    }

    public static function table(Table $table): Table
    {
        return self::product_table($table);
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
            'index' => Pages\ListProducts::route('/'),
            // 'create' => Pages\CreateProduct::route('/create'),
            // 'view' => Pages\ViewProduct::route('/{record}'),
            // 'edit' => Pages\EditProduct::route('/{record}/edit'),
            'activities' => ProductActivityLogPage::route('/{record}/activities'),
        ];
    }
}
