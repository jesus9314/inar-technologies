<?php

namespace App\Traits\Forms;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;

trait TraitForms
{
    /**
     * BrandResource
     */
    protected static function brand_form(Form $form): Form
    {
        return $form
            ->schema(self::brand_schema())
            ->columns(2);
    }

    protected static function brand_schema(): array
    {
        return [
            TextInput::make('name')
                ->label('Nombre')
                ->unique()
                ->required()
                ->live(onBlur: true)
                ->columnSpan([
                    'default' => 1,
                    'md' => 1,
                ])
                ->afterStateUpdated(function (Set $set, $state, HasForms $livewire, TextInput $component): void {
                    self::validate_one_field($livewire, $component);
                    $set('slug', Str::slug($state));
                })
                ->maxLength(255),
            TextInput::make('slug')
                ->disabled()
                ->reactive()
                ->unique(ignoreRecord: true)
                ->afterStateUpdated(fn (HasForms $livewire, TextInput $component) => self::validate_one_field($livewire, $component))
                ->required()
                ->maxLength(255),
            Textarea::make('description')
                ->label('Descripción')
                ->columnSpan([
                    'default' => 1,
                    'md' => 1,
                ])
                ->columnSpanFull(),
            FileUpload::make('image_url')
                ->label('Logo')
                ->image()
                ->optimize('webp')
                ->resize(50)
                ->directory('brand_logos'),
        ];
    }

    /**
     * CategoryResource
     */
    protected static function category_form(Form $form): Form
    {
        return $form
            ->schema(self::category_schema());
    }

    protected static function category_schema(): array
    {
        return [
            TextInput::make('name')
                ->required()
                ->label('Nombre')
                ->unique(ignoreRecord: true)
                ->live(onBlur: true)
                ->afterStateUpdated(function (Set $set, $state, HasForms $livewire, TextInput $component): void {
                    self::validate_one_field($livewire, $component);
                    $set('slug', Str::slug($state));
                })
                ->maxLength(255),
            TextInput::make('slug')
                ->disabled()
                ->reactive()
                ->unique(ignoreRecord: true)
                ->afterStateUpdated(fn (HasForms $livewire, TextInput $component) => self::validate_one_field($livewire, $component))
                ->required()
                ->maxLength(255),
            Textarea::make('description'),
            FileUpload::make('image_url')
                ->label('Imagen')
                ->imageEditor()
                ->image()
                ->optimize('webp')
                ->resize(50)
                ->directory('categories_img'),
        ];
    }

    /**
     * CurrencyResource
     */
    protected static function currency_form(Form $form): Form
    {
        return $form
            ->schema(self::currency_schema());
    }

    protected static function currency_schema(): array
    {
        return [
            TextInput::make('code')
                ->label('Código')
                ->unique(ignoreRecord: true)
                ->live(onBlur: true)
                ->afterStateUpdated(fn (HasForms $livewire, TextInput $component) => self::validate_one_field($livewire, $component))
                ->required()
                ->maxLength(255),
            Textarea::make('description')
                ->label('Descripción')
                ->required(),
            TextInput::make('symbol')
                ->label('Símbolo')
                ->required()
                ->maxLength(255),
            Select::make('activity_state_id')
                ->label('Estado')
                ->relationship('activityState', 'description')
                ->searchable()
                ->preload()
                ->native(false)
                ->required(),
        ];
    }

    /**
     * UnityResource
     */
    protected static function unit_form(Form $form): Form
    {
        return $form
            ->schema(self::unity_schema());
    }

    protected static function unit_schema(): array
    {
        return [
            TextInput::make('code')
                ->label('Código')
                ->unique(ignoreRecord: true)
                ->live(onBlur: true)
                ->afterStateUpdated(fn (HasForms $livewire, TextInput $component) => self::validate_one_field($livewire, $component))
                ->required()
                ->maxLength(255),
            TextInput::make('description')
                ->label('Descripción')
                ->required()
                ->maxLength(255),
            TextInput::make('symbol')
                ->label('Símbolo')
                ->required()
                ->maxLength(255),
            Select::make('activity_state_id')
                ->label('Estado')
                ->relationship('activityState', 'description')
                ->searchable()
                ->preload()
                ->native(false)
                ->required()
                ->default(1),
        ];
    }

    /**
     * WarehouseResource
     */
    protected static function warehouse_form(Form $form): Form
    {
        return $form
            ->schema(self::warehouse_schema());
    }

    protected static function warehouse_schema(): array
    {
        return [
            TextInput::make('description')
                ->label('Descripción')
                ->required()
                ->maxLength(255),
            TextInput::make('stablishment')
                ->label('Establecimiento')
                ->required()
                ->maxLength(255),
        ];
    }

    protected static function operating_system_form(): array
    {
        return [
            TextInput::make('description')
                ->required()
                ->maxLength(255),
            FileUpload::make('image_url')
                ->image(),
        ];
    }

    protected static function graphics_form(): array
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
                ->createOptionForm(self::brand_schema())
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

    protected static function peripheral_form(): array
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
                ->createOptionForm(self::brand_schema())
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

    protected static function ram_form(): array
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
                ->createOptionForm(self::brand_schema())
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

    protected static function memory_type_form(): array
    {
        return [
            TextInput::make('description')
                ->required()
                ->maxLength(255),
        ];
    }

    protected static function ram_form_factor_form(): array
    {
        return [
            TextInput::make('description')
                ->required()
                ->maxLength(255),
        ];
    }

    protected static function peripheral_type_form(): array
    {
        return [
            TextInput::make('description')
                ->required()
                ->maxLength(255),
        ];
    }

    protected static function district_form(): array
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

    protected static function device_type_form(): array
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

    protected static function validate_one_field(HasForms $livewire, TextInput $component): void
    {
        $livewire->validateOnly($component->getStatePath());
    }

    protected static function affectation_form(Form $form): Form
    {
        return $form
            ->schema(self::affectation_schema());
    }

    protected static function affectation_schema(): array
    {
        return [
            TextInput::make('code')
                ->label('Código')
                ->required()
                ->maxLength(255),
            TextInput::make('description')
                ->label('Descripción')
                ->required()
                ->maxLength(255),
        ];
    }
}
