<?php

namespace App\Filament\Clusters\ProductsManage\Resources;

use App\Filament\Clusters\ProductsManage;
use App\Filament\Clusters\ProductsManage\Resources\ProductResource\Pages;
use App\Filament\Clusters\ProductsManage\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use App\Traits\TraitForms;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Pages\SubNavigationPosition;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class ProductResource extends Resource
{
    use TraitForms;

    protected static ?string $model = Product::class;

    protected static ?string $cluster = ProductsManage::class;

    protected static ?string $navigationIcon = 'heroicon-c-building-storefront';

    protected static ?string $modelLabel = 'Producto';

    protected static ?string $pluralModelLabel = 'Productos';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('unit_id', '!=', 1);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema(self::product_form());
    }

    public static function setSlug(Get $get, Set $set): void
    {
        $set('slug', Str::slug($get('name')));
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('secondary_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('slug')
                    ->searchable(),
                Tables\Columns\TextColumn::make('model')
                    ->searchable(),
                Tables\Columns\TextColumn::make('bar_code')
                    ->searchable(),
                Tables\Columns\TextColumn::make('internal_code')
                    ->searchable(),
                Tables\Columns\TextColumn::make('due_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\ImageColumn::make('image_url'),
                Tables\Columns\TextColumn::make('description')
                    ->searchable(),
                Tables\Columns\TextColumn::make('stock_initial')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('stock_final')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('unity_price')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('affectation.id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('category.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('brand.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('currency.id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('unit.id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'create' => Pages\CreateProduct::route('/create'),
            'view' => Pages\ViewProduct::route('/{record}'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
