<?php

namespace App\Filament\Clusters\Purchases\Resources;

use App\Filament\Clusters\Purchases;
use App\Filament\Clusters\Purchases\Resources\PurchaseResource\Pages;
use App\Filament\Clusters\Purchases\Resources\PurchaseResource\RelationManagers;
use App\Models\Purchase;
use Filament\Forms;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Icetalker\FilamentTableRepeater\Forms\Components\TableRepeater;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PurchaseResource extends Resource
{
    protected static ?string $model = Purchase::class;

    protected static ?string $navigationIcon = 'heroicon-o-cube';

    protected static ?string $cluster = Purchases::class;

    protected static ?string $modelLabel = 'Compra';

    protected static ?string $pluralModelLabel = 'Compras';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Datos de la compra')
                    ->columns(2)
                    ->description('Ingrese los datos de la compra realizada, los valores totales del subtotal, igv y precio total, serán calculados automáticament')
                    ->collapsible()
                    ->schema([
                        Forms\Components\DatePicker::make('date_of_issue')
                            ->required(),
                        Forms\Components\DatePicker::make('date_of_reception')
                            ->required(),
                        Forms\Components\TextInput::make('price')
                            ->numeric()
                            ->readOnly()
                            ->disabled()
                            ->live(onBlur: true)
                            ->afterStateHydrated(function (Set $set, Get $get) {
                                self::updatePrices($get, $set);
                            })
                            ->prefix('s/'),
                        Forms\Components\TextInput::make('igv')
                            ->disabled()
                            ->numeric()
                            ->step('0.01')
                            ->prefix('s/'),
                        Forms\Components\TextInput::make('total_price')
                            ->disabled()
                            ->numeric()
                            ->prefix('s/'),
                        Forms\Components\TextInput::make('series')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('number')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Select::make('tax_document_type_id')
                            ->relationship('taxDocumentType', 'description')
                            ->default(2)
                            ->searchable()
                            ->preload()
                            ->required(),
                        Forms\Components\Select::make('supplier_id')
                            ->relationship('supplier', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Forms\Components\Select::make('currency_id')
                            ->relationship('currency', 'description')
                            ->default(1)
                            ->searchable()
                            ->preload()
                            ->required(),
                        Forms\Components\Select::make('action_id')
                            ->disabled()
                            ->relationship('action', 'description')
                            ->searchable()
                            ->default(1)
                            ->preload()
                            ->required(),
                    ]),
                TableRepeater::make('productPurchase')
                    ->label('Productos y Servicios')
                    ->relationship()
                    ->schema([
                        Select::make('product_id')
                            ->relationship('product', 'name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->disableOptionWhen(function ($value, $state, Get $get) {
                                return collect($get('../*.product_id'))
                                    ->reject(fn ($id) => $id == $state)
                                    ->filter()
                                    ->contains($value);
                            })
                            ->createOptionForm([
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
                            ]),
                        TextInput::make('quantity')
                            ->required()
                            ->label('Cantidad')
                            ->live()
                            ->numeric(),
                        TextInput::make('price')
                            ->required()
                            ->label('precio')
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (Set $set, Get $get, $state) {
                                self::updatePSPrices($get, $set);
                            })
                            ->numeric(),
                        TextInput::make('igv')
                            ->required()
                            ->label('I.G.V')
                            ->live()
                            ->numeric(),
                        TextInput::make('total_price')
                            ->required()
                            ->label('Precio Total')
                            ->numeric(),
                    ])
                    ->live(onBlur: true)
                    ->afterStateUpdated(function (Set $set, Get $get) {
                        self::updatePrices($get, $set);
                    })
                    ->collapsible()
                    ->deleteAction(
                        fn (Action $action) => $action->after(fn (Get $get, Set $set) => self::updatePrices($get, $set)),
                    ),
                Section::make('Comprobantes')
                    ->description('Tómele foto o escanee los documentos relacionados con esta compra para tener almacenado toda información relacionada')
                    ->collapsible()
                    ->columns([
                        'sm' => 1,
                        'md' => 2,
                        '2xl' => 3
                    ])
                    ->schema([
                        TableRepeater::make('vouchers')
                            ->relationship()
                            ->columnSpan([
                                'sm' => 1,
                                'md' => 2,
                                '2xl' => 3
                            ])
                            ->simple(
                                FileUpload::make('document_url')
                                    ->required(),
                            )
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('date_of_issue')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('date_of_reception')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('price')
                    ->money()
                    ->sortable(),
                Tables\Columns\TextColumn::make('igv')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_price')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('series')
                    ->searchable(),
                Tables\Columns\TextColumn::make('number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('taxDocumentType.id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('supplier.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('currency.id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('action_id')
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
            'index' => Pages\ListPurchases::route('/'),
            'create' => Pages\CreatePurchase::route('/create'),
            'view' => Pages\ViewPurchase::route('/{record}'),
            'edit' => Pages\EditPurchase::route('/{record}/edit'),
        ];
    }

    public static function updatePSPrices(Get $get, Set $set): void
    {
        $quantity = $get('quantity');
        $price = $get('price');
        $subtotal = $price * $quantity;
        $igv = ($subtotal) * 0.18;
        $total_price = $subtotal + $igv;

        $set('igv', $igv);
        $set('total_price', $total_price);
    }

    public static function updatePrices(Get $get, Set $set): void
    {
        $selectedProducts  = collect($get('productPurchase'))->filter(fn ($item) => !empty($item['product_id']) && !empty($item['quantity']) && !empty($item['price']));
        $price = $selectedProducts->reduce(function ($subtotal, $product) {
            return $subtotal + ($product['quantity'] * $product['price']);
        });
        $igv = $price * 0.18;
        $total = $price + $igv;

        $set('price', $price);
        $set('igv', $igv);
        $set('total_price', $total);
    }
}
