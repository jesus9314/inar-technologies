<?php

namespace App\Traits\Forms;

use Awcodes\TableRepeater\Components\TableRepeater as ComponentsTableRepeater;
use Awcodes\TableRepeater\Header;
use DesignTheBox\BarcodeField\Forms\Components\BarcodeInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Support\Enums\Alignment;
use Icetalker\FilamentTableRepeater\Forms\Components\TableRepeater;
use Illuminate\Database\Eloquent\Builder;
use Pelmered\FilamentMoneyField\Forms\Components\MoneyInput;
use Illuminate\Support\Str;

trait ProductTraitForms
{
    use TraitForms;

    protected static function product_form(Form $form): Form
    {
        return $form
            ->schema(self::product_schema());
    }

    protected static function product_schema(): array
    {
        return [
            Wizard::make()
                ->schema([
                    Step::make('General')
                        ->schema(self::general_product_info())
                        ->columns(2),
                    Step::make('Stock')
                        ->schema(self::stock())
                        ->columns(2),
                    Step::make('Adicional')
                        ->schema(self::product_relations_form())
                        ->description('Categorías, marcas, moneda, unidad, depósito, etc...')
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
                ->afterStateUpdated(fn(HasForms $livewire, TextInput $component) => self::validate_one_field($livewire, $component))
                ->label('Nombre')
                ->autocapitalize('sentencecs')
                ->live(onBlur: true)
                ->required()
                ->afterStateUpdated(fn(Get $get, Set $set) => self::setSlug($get, $set))
                ->maxLength(255),
            TextInput::make('slug')
                ->helperText(str('El campo **Nombre** se convertirá automáticamente en el slug')->inlineMarkdown()->toHtmlString())
                ->afterStateUpdated(fn(HasForms $livewire, TextInput $component) => self::validate_one_field($livewire, $component))
                ->required()
                ->unique(ignoreRecord: true)
                ->disabled()
                ->dehydrated()
                ->beforeStateDehydrated(fn(Get $get, Set $set) => self::setSlug($get, $set))
                ->maxLength(255),
            TextInput::make('duration')
                ->label('Duración')
                ->suffixIcon('heroicon-m-clock')
                ->helperText('En días, horas, minutos, etc... ')
                ->hidden(fn(Get $get) => !self::isService($get))
                ->required(fn(Get $get) => self::isService($get))
                ->disabled(fn(Get $get) => !self::isService($get)),
            TextInput::make('secondary_name')
                ->label('Nombre secundario')
                ->maxLength(255),
            TextInput::make('model')
                ->label('Modelo')
                ->maxLength(255),
            BarcodeInput::make('bar_code')
                ->helperText('Si cuentas con una pistola lectora de códigos de Barra, puedes emplearla aquí')
                ->label('Código de Barras')
                ->maxLength(255)
                ->required(false)
                ->icon('heroicon-o-viewfinder-circle'),
            TextInput::make('internal_code')
                ->label('Código Interno')
                ->maxLength(255),
            Toggle::make('service')
                ->inline(false)
                ->helperText('Si estás creando un servicio, activa esta opción')
                ->label('Servicio?')
                ->live(onBlur: true)
                ->declined()
                ->onColor('success')
                ->offColor('danger')
                ->onIcon('heroicon-o-check')
                ->offIcon('heroicon-o-x-mark'),
            MoneyInput::make('unity_price')
                ->label('Precio Unitario')
                ->required(),
            RichEditor::make('description')
                ->columnSpanFull()
                ->label('Descripción')
                ->maxLength(255),
        ];
    }

    protected static function stock(): array
    {

        return [
            DatePicker::make('due_date')
                ->native(false)
                ->seconds(false)
                ->default(now()->addWeek(1))
                ->helperText('La fecha seleccionada por defecto es 1 semana posterior al registro, puedes cambiarlo dependiendo de lo necesario')
                ->minDate(now()->subYears(2))
                ->maxDate(now()->addYears(2))
                ->closeOnDateSelection()
                ->columnSpan(fn(Get $get) => self::isService($get) ? '2' : '1')
                // ->columnSpanFull(fn(Get $get) => self::isService($get) ? true : false)
                ->label('Fecha de vencimiento'),
            TextInput::make('stock_initial')
                ->label('Stock Inicial')
                ->required(fn(Get $get) => !self::isService($get))
                ->disabled(fn(Get $get) => self::isService($get))
                ->hidden(fn(Get $get) => self::isService($get))
                ->numeric()
                ->integer()
                ->minValue(0)
                ->default(1),
            TextInput::make('stock_final')
                ->disabled()
                ->required(fn(Get $get) => !self::isService($get))
                ->disabled(fn(Get $get) => self::isService($get))
                ->hidden(fn(Get $get) => self::isService($get))
                ->numeric()
                ->minValue(0)
                ->hiddenOn('create')
                ->label('Stock Final')
                ->integer(),
            TextInput::make('stock_min')
                ->numeric()
                ->integer()
                ->minValue(0)
                ->default(0)
                ->required(fn(Get $get) => !self::isService($get))
                ->disabled(fn(Get $get) => self::isService($get))
                ->hidden(fn(Get $get) => self::isService($get))
                ->label('Stock Mínimo'),
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
                    modifyQueryUsing: fn(Builder $query) => $query->where('id', '!=', 1)
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

    protected static function isService(Get $get): bool
    {
        $service = $get('service');

        return $service ? true : false;
    }

    protected static function setSlug(Get $get, Set $set): void
    {
        $set('slug', Str::slug($get('name')));
    }
}
