<?php

namespace App\Traits\Forms;

use App\Enums\ColorEnum;
use App\Enums\ColorsEnums;
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
use Pelmered\FilamentMoneyField\Forms\Components\MoneyInput;

trait TraitForms
{
    /**
     * ProcessorSufixResource
     */
    protected static function processor_sufix_form(Form $form): Form
    {
        return $form->schema(self::processor_sufix_schema());
    }

    protected static function processor_sufix_schema(): array
    {
        return [
            TextInput::make('name')
                ->label('Sufijo')
                ->required()
                ->maxLength(255),
            TextInput::make('description')
                ->label('Descripcion')
                ->maxLength(255),
            Select::make('processor_manufacturer_id')
                ->relationship('processor_manufacturer', 'name')
                ->label('Fabricante')
                ->preload()
                ->searchable()
                ->native(false)
                ->required(),
        ];
    }

    /**
     * ProcessorConditionResource
     */
    protected static function processor_condition_form(Form $form): Form
    {
        return $form->schema(self::processor_condition_schema());
    }

    protected static function processor_condition_schema(): array
    {
        return [
            TextInput::make('description')
                ->label('Nombre')
                ->columnSpanFull()
                ->unique(ignoreRecord: true)
                ->required()
                ->maxLength(255)
        ];
    }

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
                ->dehydrated()
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

    /**
     * PresentationResource
     */
    protected static function presentation_form(Form $form): Form
    {
        return $form
            ->schema(self::presentation_schema());
    }

    protected static function presentation_schema(): array
    {
        return [
            TextInput::make('bar_code')
                ->label('Código de Barras')
                ->required()
                ->maxLength(255),
            TextInput::make('description')
                ->label('Descripción')
                ->required()
                ->maxLength(255),
            TextInput::make('factor')
                ->label('Factor')
                ->required()
                ->numeric(),
            MoneyInput::make('price')
                ->label('Precio')
                ->required(),
            Select::make('product_id')
                ->relationship('product', 'name')
                ->searchable()
                ->preload()
                ->native(false)
                ->required(),
        ];
    }

    /**
     * IssuePriorityResource
     */
    protected static function issue_priority_form(Form $form): Form
    {
        return $form
            ->schema(self::issue_priority_schema());
    }

    protected static function issue_priority_schema(): array
    {
        return [
            TextInput::make('name')
                ->required()
                ->label('Nombre')
                ->maxLength(255),
            Select::make('color')
                ->searchable()
                ->options(ColorsEnums::class),
        ];
    }

    /**
     * MaintenancesStateResource
     */
    protected static function maintenances_state_form(Form $form): Form
    {
        return $form->schema(self::maintenances_state_schema());
    }

    protected static function maintenances_state_schema(): array
    {
        return [
            TextInput::make('name')
                ->required()
                ->maxLength(255),
            Select::make('type')
                ->required()
                ->label('Tipo')
                ->searchable()
                ->native(false)
                ->options([
                    'issue' => 'Problemas',
                    'solution' => 'Solución',
                    'maintenance' => 'Mantenimiento'
                ]),
            Select::make('color')
                ->required('')
                ->options(ColorEnum::class)
        ];
    }

    /**
     * MemoryTypeResource
     */
    protected static function memory_type_form(Form $form): Form
    {
        return $form->schema(self::memory_type_schema());
    }

    protected static function memory_type_schema(): array
    {
        return [
            TextInput::make('description')
                ->required()
                ->label('Nombre')
                ->maxLength(255)
                ->columnSpanFull(),
        ];
    }

    /**
     * RamFormFactorResource
     */
    protected static function ram_form_factor_form(Form $form): Form
    {
        return $form->schema(self::ram_form_factor_schema());
    }

    protected static function ram_form_factor_schema(): array
    {
        return [
            TextInput::make('description')
                ->label('Nombre')
                ->columnSpanFull()
                ->required()
                ->maxLength(255),
        ];
    }

    /**
     * DeviceTypeResource
     */
    protected static function device_type_form(Form $form): Form
    {
        return $form()->schema(self::device_type_schema());
    }

    protected static function device_type_schema(): array
    {
        return [
            TextInput::make('description')
                ->required()
                ->label('Descripción')
                ->maxLength(255),
            TextInput::make('symbol')
                ->label('Símbolo')
                ->required()
                ->maxLength(255),
        ];
    }

    /**
     * DistrictResource
     */
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

    protected static function validate_one_field(HasForms $livewire, TextInput $component): void
    {
        $livewire->validateOnly($component->getStatePath());
    }
    
    /**
     * AffectattionResource
     */
    protected static function affectation_form(Form $form): Form
    {
        return $form
            ->columns(2)
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
                ->label('Nombre')
                ->required()
                ->maxLength(255),
        ];
    }
}
