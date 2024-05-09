<?php

namespace App\Traits\Forms;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Illuminate\Database\Eloquent\Builder;
use Pelmered\FilamentMoneyField\Forms\Components\MoneyInput;
use Illuminate\Support\Str;

trait ProductTraitForms
{
    use TraitForms;

    protected static function product_form(): array
    {
        return [
            Wizard::make()
                ->schema([
                    Step::make('Información General')
                        ->schema(self::general_product_info())
                        ->columns(2),
                    Step::make('Relaciones')
                        ->schema(self::product_relations_form())
                        ->columns(2),
                ])
                ->columnSpanFull()
                ->skippable()
        ];
    }

    protected static function general_product_info(): array
    {
        return [
            TextInput::make('name')
                ->required()
                ->unique(ignoreRecord: true)
                ->afterStateUpdated(fn (HasForms $livewire, TextInput $component) => self::validate_one_field($livewire, $component))
                ->label('Nombre')
                ->autocapitalize('sentencecs')
                ->live(onBlur: true)
                ->required()
                ->afterStateUpdated(fn (Get $get, Set $set) => self::setSlug($get, $set))
                ->maxLength(255),
            TextInput::make('slug')
                ->helperText(str('El campo **Nombre** se convertirá automáticamente en el slug')->inlineMarkdown()->toHtmlString())
                ->afterStateUpdated(fn (HasForms $livewire, TextInput $component) => self::validate_one_field($livewire, $component))
                ->required()
                ->unique(ignoreRecord: true)
                ->disabled()
                ->dehydrated()
                ->beforeStateDehydrated(fn (Get $get, Set $set) => self::setSlug($get, $set))
                ->maxLength(255),
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
                ->required()
                ->default(0)
                ->numeric(),
            TextInput::make('stock_final')
                ->hiddenOn('create')
                ->disabled()
                ->label('Stock Final')
                ->numeric(),
            TextInput::make('stock_min')
                ->numeric()
                ->integer()
                ->label('Stock Mínimo'),
            MoneyInput::make('unity_price')
                ->label('Precio Unitario')
                ->required(),
        ];
    }

    protected static function product_relations_form(): array
    {
        return [
            Select::make('affectation_id')
                ->label('Tipos de afectación al IGV')
                ->searchable()
                ->preload()
                ->relationship('affectation', 'description')
                ->default(1)
                ->required(),
            Select::make('category_id')
                ->label('Categoría')
                ->createOptionForm(self::category_schema())
                ->searchable()
                ->preload()
                ->relationship('category', 'name'),
            Select::make('brand_id')
                ->label('Marca')
                ->createOptionForm(self::brand_schema())
                ->searchable()
                ->preload()
                ->relationship('brand', 'name'),
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
                ->label('Depósito')
                ->preload()
                ->multiple()
                ->relationship(titleAttribute: 'description')
                ->required(),
            FileUpload::make('image_url')
                ->label('Imagen del producto')
                ->image()
                ->columnSpan(2),
        ];
    }

    protected static function setSlug(Get $get, Set $set): void
    {
        $set('slug', Str::slug($get('name')));
    }
}
