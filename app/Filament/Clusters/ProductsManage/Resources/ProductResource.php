<?php

namespace App\Filament\Clusters\ProductsManage\Resources;

use App\Filament\Clusters\ProductsManage;
use App\Filament\Clusters\ProductsManage\Resources\ProductResource\Pages;
use App\Filament\Clusters\ProductsManage\Resources\ProductResource\RelationManagers;
use App\Models\Product;
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
            ->schema([
                Section::make()
                    ->columns(2)
                    ->schema([
                        Fieldset::make('Nombre')
                            ->schema([
                                TextInput::make('name')
                                    ->required()
                                    ->label('Nombre')
                                    ->autocapitalize('sentencecs')
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn (Get $get, Set $set) => self::setSlug($get, $set))
                                    ->maxLength(255),
                                TextInput::make('slug')
                                    ->required()
                                    ->readOnly()
                                    ->disabled()
                                    ->beforeStateDehydrated(fn (Get $get, Set $set) => self::setSlug($get, $set))
                                    ->maxLength(255),
                            ]),
                        TextInput::make('secondary_name')
                            ->label('Nombre secundario')
                            ->maxLength(255),
                        TextInput::make('model')
                            ->label('Modelo')
                            ->maxLength(255),
                        TextInput::make('bar_code')
                            ->label('Código de Barras')
                            ->maxLength(255),
                        TextInput::make('internal_code')
                            ->label('Código Interno')
                            ->maxLength(255),
                        DatePicker::make('due_date')
                            ->label('Fecha de vencimiento'),
                        TextInput::make('description')
                            ->label('descripción del producto')
                            ->maxLength(255),
                        TextInput::make('stock_initial')
                            ->label('Stock Inicial')
                            ->numeric(),
                        TextInput::make('stock_final')
                            ->label('Stock Final')
                            ->numeric(),
                        TextInput::make('unity_price')
                            ->label('Precio Unitario')
                            ->required()
                            ->numeric()
                            ->prefix('S/'),
                        Select::make('affectation_id')
                            ->label('Tipos de afectación al IGV')
                            ->searchable()
                            ->preload()
                            ->relationship('affectation', 'description')
                            ->default(1)
                            ->required(),
                        Select::make('category_id')
                            ->label('Categoría')
                            ->searchable()
                            ->preload()
                            ->relationship('category', 'name')
                            ->required(),
                        Select::make('brand_id')
                            ->label('Marca')
                            ->searchable()
                            ->preload()
                            ->relationship('brand', 'name')
                            ->required(),
                        Select::make('currency_id')
                            ->label('Moneda')
                            ->searchable()
                            ->preload()
                            ->relationship('currency', 'description')
                            ->default(1)
                            ->required(),
                        Select::make('unit_id')
                            ->label('Unidad')
                            ->searchable()
                            ->preload()
                            ->relationship(
                                name: 'unit',
                                titleAttribute: 'description',
                                modifyQueryUsing: fn (Builder $query) => $query->where('id', '!=', 1)
                            )
                            ->default(10)
                            ->required(),
                        Select::make('warehouses')
                            ->preload()
                            ->multiple()
                            ->relationship(titleAttribute: 'description')
                            ->required(),
                        FileUpload::make('image_url')
                            ->label('Imagen del producto')
                            ->image()
                            ->columnSpan(2),
                    ])

            ]);
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
