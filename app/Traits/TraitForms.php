<?php

namespace App\Traits;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Icetalker\FilamentTableRepeater\Forms\Components\TableRepeater;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;
use Pelmered\FilamentMoneyField\Forms\Components\MoneyInput;
use Pelmered\FilamentMoneyField\Infolists\Components\MoneyEntry;
use Ysfkaya\FilamentPhoneInput\Forms\PhoneInput;

trait TraitForms
{
    public static function brand_form(): array
    {
        return [
            TextInput::make('name')
                ->required()
                ->live(onBlur: true)
                ->columnSpan([
                    'default' => 1,
                    'md' => 1,
                ])
                ->afterStateUpdated(fn (Set $set, $state) => $set('slug', Str::slug($state)))
                ->maxLength(255),
            TextInput::make('slug')
                ->readOnly()
                ->columnSpan([
                    'default' => 1,
                    'md' => 1,
                ])
                ->required()
                ->maxLength(255),
            Textarea::make('description')
                ->columnSpan([
                    'default' => 1,
                    'md' => 1,
                ])
                ->columnSpanFull(),
            FileUpload::make('image_url')
                ->columnSpan([
                    'default' => 1,
                    'md' => 1,
                ])
                ->image(),
        ];
    }

    public static function operating_system_form(): array
    {
        return [
            TextInput::make('description')
                ->required()
                ->maxLength(255),
            FileUpload::make('image_url')
                ->image(),
        ];
    }

    public static function graphics_form(): array
    {
        return [
            TextInput::make('model')
                ->required()
                ->maxLength(255),
            TextInput::make('clock')
                ->required()
                ->maxLength(255),
            TextInput::make('memory_capacity')
                ->required()
                ->maxLength(255),
            FileUpload::make('image_url')
                ->image()
                ->required(),
            TextInput::make('specifications_url')
                ->required()
                ->maxLength(255),
            Select::make('brand_id')
                ->relationship('brand', 'name')
                ->createOptionForm(self::brand_form())
                ->searchable()
                ->preload()
                ->required(),
            Select::make('memory_type_id')
                ->relationship('memoryType', 'description')
                ->createOptionForm(self::memory_type_form())
                ->searchable()
                ->preload()
                ->required(),
        ];
    }

    public static function peripheral_form(): array
    {
        return [
            TextInput::make('description')
                ->required()
                ->maxLength(255),
            FileUpload::make('image_url')
                ->image()
                ->required(),
            Select::make('brand_id')
                ->relationship('brand', 'name')
                ->createOptionForm(self::brand_form())
                ->searchable()
                ->preload()
                ->required(),
            Select::make('peripheral_type_id')
                ->relationship('peripheralType', 'description')
                ->createOptionForm(self::peripheral_type_form())
                ->searchable()
                ->preload()
                ->required(),
        ];
    }

    public static function ram_form(): array
    {
        return [
            TextInput::make('speed')
                ->required()
                ->maxLength(255),
            TextInput::make('capacity')
                ->required()
                ->maxLength(255),
            TextInput::make('latency')
                ->maxLength(255),
            Textarea::make('description')
                ->columnSpanFull(),
            FileUpload::make('image_url')
                ->image(),
            TextInput::make('specifications_link')
                ->maxLength(255),
            Select::make('brand_id')
                ->relationship('brand', 'name')
                ->createOptionForm(self::brand_form())
                ->searchable()
                ->preload()
                ->required(),
            Select::make('ram_form_factor_id')
                ->relationship('ramFormFactor', 'description')
                ->createOptionForm(self::ram_form_factor_form())
                ->searchable()
                ->preload()
                ->required(),
            Select::make('memory_type_id')
                ->relationship('memoryType', 'description')
                ->createOptionForm(self::memory_type_form())
                ->searchable()
                ->preload()
                ->required(),
        ];
    }

    public static function memory_type_form(): array
    {
        return [
            TextInput::make('description')
                ->required()
                ->maxLength(255),
        ];
    }

    public static function ram_form_factor_form(): array
    {
        return [
            TextInput::make('description')
                ->required()
                ->maxLength(255),
        ];
    }

    public static function peripheral_type_form(): array
    {
        return [
            TextInput::make('description')
                ->required()
                ->maxLength(255),
        ];
    }

    public static function district_form(): array
    {
        return [
            TextInput::make('name')
                ->required()
                ->maxLength(255),
            TextInput::make('status')
                ->required(),
            Select::make('country_id')
                ->relationship('country', 'name')
                ->searchable()
                ->preload()
                ->live()
                ->required(),
            Select::make('department_id')
                ->relationship(
                    name: 'department',
                    titleAttribute: 'name',
                    modifyQueryUsing: fn (Builder $query, Get $get) => $query->where('country_id', $get('country_id'))
                )
                ->disabled(fn (Get $get): bool => !filled($get('country_id')))
                ->live()
                ->required(),
            Select::make('province_id')
                ->relationship(
                    name: 'province',
                    titleAttribute: 'name',
                    modifyQueryUsing: fn (Builder $query, Get $get) => $query->where('department_id', $get('department_id'))
                )
                ->disabled(fn (Get $get): bool => !filled($get('department_id')))
                ->required(),
        ];
    }

    public static function device_type_form(): array
    {
        return [
            TextInput::make('description')
                ->required()
                ->maxLength(255),
            TextInput::make('symbol')
                ->required()
                ->maxLength(255),
        ];
    }

    public static function product_form(): array
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

    public static function general_product_info(): array
    {
        return [
            TextInput::make('name')
                ->required()
                ->label('Nombre')
                ->autocapitalize('sentencecs')
                ->live(onBlur: true)
                ->afterStateUpdated(fn (Get $get, Set $set) => self::setSlug($get, $set))
                ->maxLength(255),
            TextInput::make('slug')
                ->helperText(str('El campo **Nombre** se convertirá automáticamente en el slug')->inlineMarkdown()->toHtmlString())
                ->required()
                ->readOnly()
                ->disabled()
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
            MoneyInput::make('unity_price')
                ->label('Precio Unitario')
                ->required(),
        ];
    }

    public static function product_relations_form(): array
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
        ];
    }

    public static function service_form(): array
    {
        return [
            TextInput::make('name')
                ->required()
                ->maxLength(255),
            TextInput::make('slug')
                ->required()
                ->maxLength(255),
            TextInput::make('description')
                ->required()
                ->maxLength(255),
        ];
    }
}
