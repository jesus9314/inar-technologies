<?php

namespace App\Filament\Plugins\CustomFilamentEcommercePlugin\Resources;

use App\Filament\Plugins\CustomFilamentEcommercePlugin\Resources\ProductResource\Pages\CreateProduct;
use App\Filament\Plugins\CustomFilamentEcommercePlugin\Resources\ProductResource\Pages\EditProduct;
use App\Filament\Plugins\CustomFilamentEcommercePlugin\Resources\ProductResource\Pages\ListProducts;
use App\Models\Product;
// use App\Filament\Plugins\CustomFilamentEcommercePlugin\Resources\ProductResource\RelationManagers\ProductReviewManager;
use TomatoPHP\FilamentEcommerce\Filament\Resources\ProductResource as BaseProductResource;
use TomatoPHP\FilamentEcommerce\Filament\Resources\ProductResource\RelationManagers\ProductReviewManager;
use Filament\Forms;
use Filament\Forms\Form;
use TomatoPHP\FilamentCms\Models\Category;
use Illuminate\Support\Str;

class ProductResource extends BaseProductResource
{
    // protected static ?string $model = Product::class;
    
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Tabs::make('Tabs')
                    ->tabs([
                        Forms\Components\Tabs\Tab::make(trans('filament-ecommerce::messages.product.tabs.details'))
                            ->icon('heroicon-o-information-circle')
                            ->schema([
                                Forms\Components\Select::make('type')
                                    ->columnSpanFull()
                                    ->searchable()
                                    ->options([
                                        "product" => "Product",
                                        "digital" => "Digital",
                                        "service" => "Service",
                                    ])
                                    ->label(trans('filament-ecommerce::messages.product.columns.type'))
                                    ->native(false)
                                    ->default('product'),
                                Forms\Components\TextInput::make('name')
                                    ->label(trans('filament-ecommerce::messages.product.columns.name'))
                                    ->lazy()
                                    ->afterStateUpdated(fn(Forms\Get $get, Forms\Set $set) => $set('slug', \Illuminate\Support\Str::slug($get('name'))))
                                    ->required(),
                                Forms\Components\TextInput::make('slug')
                                    ->label(trans('filament-ecommerce::messages.product.columns.slug'))
                                    ->disabled()
                                    ->dehydrated()
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\Textarea::make('about')
                                    ->columnSpanFull()
                                    ->label(trans('filament-ecommerce::messages.product.columns.about')),
                                Forms\Components\TextInput::make('sku')
                                    ->default(uniqid())
                                    ->label(trans('filament-ecommerce::messages.product.columns.sku'))
                                    ->unique(Product::class, column: 'sku', ignoreRecord: true)
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('barcode')
                                    ->label(trans('filament-ecommerce::messages.product.columns.barcode'))
                                    ->unique(Product::class,  column: 'barcode', ignoreRecord: true)
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('price')
                                    ->label(trans('filament-ecommerce::messages.product.columns.price'))
                                    ->required()
                                    ->numeric()
                                    ->prefix('S/'),
                                Forms\Components\TextInput::make('vat')
                                    ->label(trans('filament-ecommerce::messages.product.columns.vat'))
                                    ->numeric()
                                    ->prefix('S/')
                                    ->default(0),
                                Forms\Components\TextInput::make('discount')
                                    ->label(trans('filament-ecommerce::messages.product.columns.discount'))
                                    ->numeric()
                                    ->live()
                                    ->prefix('S/')
                                    ->default(0),
                                Forms\Components\DateTimePicker::make('discount_to')
                                    ->rule('after:now')
                                    ->native(false)
                                    ->hidden(fn(Forms\Get $get) => !$get('discount'))
                                    ->default(now())
                                    ->label(trans('filament-ecommerce::messages.product.columns.discount_to')),
                                Forms\Components\Toggle::make('is_activated')
                                    ->columnSpanFull()
                                    ->label(trans('filament-ecommerce::messages.product.columns.is_activated')),
                                Forms\Components\Toggle::make('is_trend')
                                    ->columnSpanFull()
                                    ->label(trans('filament-ecommerce::messages.product.columns.is_trend')),
                            ])->columns(2),
                        Forms\Components\Tabs\Tab::make(trans('filament-ecommerce::messages.product.tabs.prices'))
                            ->icon('heroicon-o-currency-dollar')
                            ->schema([
                                Forms\Components\Toggle::make('is_shipped')
                                    ->label(trans('filament-ecommerce::messages.product.columns.is_shipped')),
                                Forms\Components\Toggle::make('has_multi_price')
                                    ->live()
                                    ->label(trans('filament-ecommerce::messages.product.columns.has_multi_price')),
                                Forms\Components\Repeater::make('prices')
                                    ->hidden(fn(Forms\Get $get) => !$get('has_multi_price'))
                                    ->label(trans('filament-ecommerce::messages.product.columns.prices'))
                                    ->itemLabel(fn(array $state): ?string => Str::title($state['for']) ?? null)
                                    ->collapsed()
                                    ->collapsible()
                                    ->cloneable()
                                    ->schema([
                                        Forms\Components\Select::make('for')
                                            ->searchable()
                                            ->live()
                                            ->options([
                                                "retail" => "Retail",
                                                "wholesale" => "Wholesale",
                                                "special" => "Special",
                                                "items" => "Items",
                                            ])
                                            ->default('retail')
                                            ->label(trans('filament-ecommerce::messages.product.columns.for'))
                                            ->columnSpanFull()
                                            ->required(),
                                        Forms\Components\TextInput::make('qty')
                                            ->hidden(fn(Forms\Get $get) => $get('for') !== 'items')
                                            ->label(trans('filament-ecommerce::messages.product.columns.qty'))
                                            ->required()
                                            ->numeric(),
                                        Forms\Components\TextInput::make('price')
                                            ->label(trans('filament-ecommerce::messages.product.columns.price'))
                                            ->required()
                                            ->numeric()
                                            ->prefix('$'),
                                        Forms\Components\TextInput::make('vat')
                                            ->label(trans('filament-ecommerce::messages.product.columns.vat'))
                                            ->numeric()
                                            ->prefix('$')
                                            ->default(0),
                                        Forms\Components\TextInput::make('discount')
                                            ->label(trans('filament-ecommerce::messages.product.columns.discount'))
                                            ->numeric()
                                            ->live()
                                            ->prefix('%')
                                            ->default(0),
                                        Forms\Components\DateTimePicker::make('discount_to')
                                            ->rule('after:now')
                                            ->hidden(fn(Forms\Get $get) => !$get('discount'))
                                            ->label(trans('filament-ecommerce::messages.product.columns.discount_to')),
                                    ])->columns(3)
                            ]),
                        Forms\Components\Tabs\Tab::make(trans('filament-ecommerce::messages.product.tabs.stock'))
                            ->icon('heroicon-o-home-modern')
                            ->schema([
                                Forms\Components\Toggle::make('is_in_stock')
                                    ->label(trans('filament-ecommerce::messages.product.columns.is_in_stock')),
                                Forms\Components\Toggle::make('has_unlimited_stock')
                                    ->label(trans('filament-ecommerce::messages.product.columns.has_unlimited_stock')),
                                Forms\Components\Toggle::make('has_max_cart')
                                    ->columnSpanFull()
                                    ->live()
                                    ->label(trans('filament-ecommerce::messages.product.columns.has_max_cart')),
                                Forms\Components\TextInput::make('min_cart')
                                    ->hidden(fn(Forms\Get $get) => !$get('has_max_cart'))
                                    ->label(trans('filament-ecommerce::messages.product.columns.min_cart'))
                                    ->numeric(),
                                Forms\Components\TextInput::make('max_cart')
                                    ->hidden(fn(Forms\Get $get) => !$get('has_max_cart'))
                                    ->label(trans('filament-ecommerce::messages.product.columns.max_cart'))
                                    ->numeric(),
                                Forms\Components\Toggle::make('has_stock_alert')
                                    ->columnSpanFull()
                                    ->live()
                                    ->label(trans('filament-ecommerce::messages.product.columns.has_stock_alert')),
                                Forms\Components\TextInput::make('min_stock_alert')
                                    ->hidden(fn(Forms\Get $get) => !$get('has_stock_alert'))
                                    ->label(trans('filament-ecommerce::messages.product.columns.min_stock_alert'))
                                    ->numeric(),
                                Forms\Components\TextInput::make('max_stock_alert')
                                    ->hidden(fn(Forms\Get $get) => !$get('has_stock_alert'))
                                    ->label(trans('filament-ecommerce::messages.product.columns.max_stock_alert'))
                                    ->numeric(),
                            ])->columns(2),
                        Forms\Components\Tabs\Tab::make(trans('filament-ecommerce::messages.product.tabs.seo'))
                            ->icon('heroicon-o-magnifying-glass')
                            ->schema([
                                Forms\Components\SpatieMediaLibraryFileUpload::make('feature_image')
                                    ->columnSpanFull()
                                    ->collection('feature_image')
                                    ->label(trans('filament-ecommerce::messages.product.columns.feature_image')),
                                Forms\Components\SpatieMediaLibraryFileUpload::make('gallery')
                                    ->columnSpanFull()
                                    ->columns('gallery')
                                    ->multiple()
                                    ->reorderable()
                                    ->label(trans('filament-ecommerce::messages.product.columns.gallery')),
                                Forms\Components\Select::make('category_id')
                                    ->columnSpanFull()
                                    ->searchable()
                                    ->options(
                                        Category::query()
                                            ->where('for', 'product')
                                            ->where('type', 'category')
                                            ->pluck('name', 'id')
                                            ->toArray()
                                    )
                                    ->label(trans('filament-ecommerce::messages.product.columns.category_id')),
                                Forms\Components\Select::make('categories')
                                    ->relationship('categories')
                                    ->multiple()
                                    ->searchable()
                                    ->options(
                                        Category::query()
                                            ->where('for', 'product')
                                            ->where('type', 'category')
                                            ->pluck('name', 'id')
                                            ->toArray()
                                    )
                                    ->label(trans('filament-ecommerce::messages.product.columns.categories')),
                                Forms\Components\Select::make('tags')
                                    ->relationship('tags')
                                    ->multiple()
                                    ->searchable()
                                    ->options(
                                        Category::query()
                                            ->where('for', 'product')
                                            ->where('type', 'tag')
                                            ->pluck('name', 'id')
                                            ->toArray()
                                    )
                                    ->label(trans('filament-ecommerce::messages.product.columns.tags')),
                                Forms\Components\RichEditor::make('description')
                                    ->columnSpanFull()
                                    ->label(trans('filament-ecommerce::messages.product.columns.description')),
                                Forms\Components\RichEditor::make('details')
                                    ->columnSpanFull()
                                    ->label(trans('filament-ecommerce::messages.product.columns.details')),
                                Forms\Components\Textarea::make('keywords')
                                    ->columnSpanFull()
                                    ->label(trans('filament-ecommerce::messages.product.columns.keywords')),

                            ])->columns(2),
                        Forms\Components\Tabs\Tab::make(trans('filament-ecommerce::messages.product.tabs.variation'))
                            ->icon('heroicon-o-cursor-arrow-ripple')
                            ->schema([
                                Forms\Components\Toggle::make('has_options')
                                    ->live()
                                    ->label(trans('filament-ecommerce::messages.product.columns.has_options')),
                                Forms\Components\Repeater::make('options')
                                    ->hidden(fn(Forms\Get $get) => !$get('has_options'))
                                    ->label(trans('filament-ecommerce::messages.product.columns.options.title'))
                                    ->itemLabel(fn(array $state): ?string => $state['name'] ?? null)
                                    ->collapsed()
                                    ->collapsible()
                                    ->cloneable()
                                    ->schema([
                                        Forms\Components\TextInput::make('name')
                                            ->label(trans('filament-ecommerce::messages.product.columns.options.name')),
                                        Forms\Components\Repeater::make('values')
                                            ->itemLabel(fn(array $state): ?string => $state['value'] ?? null)
                                            ->collapsed()
                                            ->collapsible()
                                            ->cloneable()
                                            ->label(trans('filament-ecommerce::messages.product.columns.options.values'))
                                            ->schema([
                                                Forms\Components\TextInput::make('value')
                                                    ->label(trans('filament-ecommerce::messages.product.columns.options.value'))
                                                    ->columnSpanFull(),
                                                Forms\Components\Toggle::make('has_custom_price')
                                                    ->label(trans('filament-ecommerce::messages.product.columns.options.has_custom_price'))
                                                    ->columnSpanFull()
                                                    ->live(),
                                                Forms\Components\Select::make('price_for')
                                                    ->label(trans('filament-ecommerce::messages.product.columns.options.price_for'))
                                                    ->hidden(fn(Forms\Get $get) => !$get('has_custom_price'))
                                                    ->searchable()
                                                    ->live()
                                                    ->options([
                                                        "retail" => "Retail",
                                                        "wholesale" => "Wholesale",
                                                        "special" => "Special",
                                                        "items" => "Items",
                                                    ])
                                                    ->default('retail')
                                                    ->required(),
                                                Forms\Components\TextInput::make('qty')
                                                    ->hidden(fn(Forms\Get $get) => $get('price_for') !== 'items')
                                                    ->label(trans('filament-ecommerce::messages.product.columns.options.qty'))
                                                    ->required()
                                                    ->numeric(),
                                                Forms\Components\TextInput::make('price')
                                                    ->hidden(fn(Forms\Get $get) => !$get('has_custom_price'))
                                                    ->label(trans('filament-ecommerce::messages.product.columns.options.price'))
                                                    ->required()
                                                    ->numeric()
                                                    ->default(0)
                                                    ->prefix('$'),
                                                Forms\Components\TextInput::make('vat')
                                                    ->hidden(fn(Forms\Get $get) => !$get('has_custom_price'))
                                                    ->label(trans('filament-ecommerce::messages.product.columns.options.vat'))
                                                    ->numeric()
                                                    ->prefix('$')
                                                    ->default(0),
                                                Forms\Components\TextInput::make('discount')
                                                    ->hidden(fn(Forms\Get $get) => !$get('has_custom_price'))
                                                    ->label(trans('filament-ecommerce::messages.product.columns.options.discount'))
                                                    ->numeric()
                                                    ->live()
                                                    ->prefix('%')
                                                    ->default(0),
                                                Forms\Components\DateTimePicker::make('discount_to')
                                                    ->hidden(fn(Forms\Get $get) => !$get('has_custom_price'))
                                                    ->rule('after:now')
                                                    ->hidden(fn(Forms\Get $get) => !$get('discount'))
                                                    ->label(trans('filament-ecommerce::messages.product.columns.options.discount_to')),
                                                Forms\Components\Toggle::make('has_color')
                                                    ->label(trans('filament-ecommerce::messages.product.columns.options.has_color'))
                                                    ->columnSpanFull()
                                                    ->live(),
                                                Forms\Components\ColorPicker::make('color')
                                                    ->label(trans('filament-ecommerce::messages.product.columns.options.color'))
                                                    ->hidden(fn(Forms\Get $get) => !$get('has_color'))
                                            ])->columns(4),
                                    ])
                            ]),
                    ])->columnSpanFull(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            ProductReviewManager::make()
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListProducts::route('/'),
            'create' => CreateProduct::route('/create'),
            'edit' => EditProduct::route('/{record}/edit'),
        ];
    }
}
