<?php

namespace App\Traits\Forms;

use App\Models\Brand;
use App\Models\MemoryType;
use App\Models\RamFormFactor;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use FilamentTiptapEditor\TiptapEditor;

trait DevicesTraitForms
{
    use TraitForms;

    /**
     * DeviceResource
     */
    protected static function device_form(Form $form): Form
    {
        return $form->schema(self::device_schema());
    }

    protected static function device_schema(): array
    {
        return [
            TextInput::make('name')
                ->hiddenOn('create')
                ->columnSpanFull(),
            Select::make('user_id')
                ->relationship('user', 'name')
                ->preload()
                ->searchable()
                ->required(),
            Select::make('device_type_id')
                ->relationship('deviceType', 'description')
                ->searchable()
                ->preload()
                ->required(),
            Textarea::make('description')
                ->columnSpanFull(),
            Textarea::make('aditional_info')
                ->columnSpanFull(),
            TextInput::make('ram_total')
                ->numeric(),
            FileUpload::make('speccy_snapshot_url')
                ->columnSpanFull(),
            Select::make('device_state_id')
                ->relationship('deviceState', 'id')
                ->searchable()
                ->preload(),
            Select::make('processor_id')
                ->relationship('processor', 'model')
                ->searchable()
                ->preload(),
            Repeater::make('deviceOperatingSystems')
                ->relationship()
                ->label('Sistemas Operativos')
                ->schema([
                    Select::make('operating_system_id')
                        ->relationship('operatingSystem', 'description')
                        ->createOptionForm(self::operating_system_schema())
                        ->preload()
                        ->searchable()
                ])
                ->defaultItems(0),
            Repeater::make('deviceGraphics')
                ->label('Tarjetas Gráficas')
                ->relationship()
                ->schema([
                    Select::make('graphic_id')
                        ->relationship('graphic', 'model')
                        ->createOptionForm(self::graphics_schema())
                        ->preload()
                        ->searchable()
                ])
                ->defaultItems(0),
            Repeater::make('devicePeripherals')
                ->label('Periféricos')
                ->relationship()
                ->schema([
                    Select::make('peripheral_id')
                        ->relationship('peripheral', 'description')
                        ->createOptionForm(self::peripheral_schema())
                        ->preload()
                        ->searchable()
                ])
                ->defaultItems(0),
            Repeater::make('deviceRams')
                ->label('Memorias Ram')
                ->relationship()
                ->schema([
                    Select::make('ram_id')
                        ->relationship('ram', 'id')
                        ->createOptionForm(self::ram_schema())
                        ->preload()
                        ->searchable(),
                    TextInput::make('quantity')
                        ->integer()
                ])
                ->defaultItems(0)
        ];
    }

    /**
     * OperatingSystemResource
     */
    protected static function operating_system_form(Form $form): Form
    {
        return $form->schema(self::operating_system_schema());
    }

    protected static function operating_system_schema(): array
    {
        return [
            TextInput::make('description')
                ->required()
                ->maxLength(255),
            FileUpload::make('image_url')
                ->image()
                ->directory('operating_system_files')
                ->optimize('webp')
                ->resize(50),
        ];
    }

    /**
     * GraphicResource
     */
    protected static function graphics_form(Form $form): Form
    {
        return $form->schema(self::graphics_schema());
    }

    protected static function graphics_schema(): array
    {
        return [
            TextInput::make('model')
                ->label('Modelo')
                ->required()
                ->maxLength(255),
            TextInput::make('clock')
                ->label('Velocidad de Reloj')
                ->required()
                ->maxLength(255),
            TextInput::make('memory_capacity')
                ->label('Capacidad de la memoria')
                ->required()
                ->maxLength(255),
            FileUpload::make('image_url')
                ->image()
                ->required(),
            TextInput::make('specifications_url')
                ->label('Link de especificaciones')
                ->prefixIcon('')
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
                ->createOptionForm(self::memory_type_schema())
                ->searchable()
                ->preload()
                ->required(),
        ];
    }

    /**
     * PeripheralResource
     */
    protected static function peripheral_form(Form $form): Form
    {
        return $form->schema(self::peripheral_schema());
    }

    protected static function peripheral_schema(): array
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
                ->createOptionForm(self::peripheral_type_schema())
                ->searchable()
                ->preload()
                ->required(),
        ];
    }

    /**
     * PeripheralTypeResource
     */
    protected static function peripheral_type_form(Form $form): Form
    {
        return $form->schema(self::peripheral_type_schema());
    }

    protected static function peripheral_type_schema(): array
    {
        return [
            TextInput::make('description')
                ->required()
                ->maxLength(255),
        ];
    }

    /**
     * RamResource
     */
    protected static function ram_form(Form $form): Form
    {
        return $form->schema(self::ram_schema());
    }

    protected static function ram_schema(): array
    {
        return [
            Wizard::make()
                ->schema([
                    Step::make('Información Principal')
                        ->schema([
                            TextInput::make('name')
                                ->label('Nombre')
                                ->disabled()
                                ->dehydrated()
                                ->columnSpanFull()
                                ->helperText(str('El nombre se creará a partir de los campos con asterisco (*)')->inlineMarkdown()->toHtmlString())
                                ->required(),
                            Select::make('brand_id')
                                ->label('Marca')
                                ->relationship('brand', 'name')
                                ->createOptionForm(self::brand_schema())
                                ->live(onBlur: true)
                                ->afterStateUpdated(fn (Get $get, Set $set) => self::get_ram_name($get, $set))
                                ->searchable()
                                ->preload()
                                ->required(),
                            TextInput::make('speed')
                                ->label('Velocidad')
                                ->suffix('GHz')
                                ->integer()
                                ->live(onBlur: true)
                                ->afterStateUpdated(fn (Get $get, Set $set) => self::get_ram_name($get, $set))
                                ->required()
                                ->maxLength(255),
                            TextInput::make('capacity')
                                ->label('Capacidad de la memoria')
                                ->numeric()
                                ->integer()
                                ->live(onBlur: true)
                                ->afterStateUpdated(fn (Get $get, Set $set) => self::get_ram_name($get, $set))
                                ->suffix('GB')
                                ->required()
                                ->maxLength(255),
                            Select::make('ram_form_factor_id')
                                ->label('Factor de Forma')
                                ->relationship('ramFormFactor', 'description')
                                ->createOptionForm(self::ram_form_factor_schema())
                                ->live(onBlur: true)
                                ->afterStateUpdated(fn (Get $get, Set $set) => self::get_ram_name($get, $set))
                                ->searchable()
                                ->preload()
                                ->required(),
                            Select::make('memory_type_id')
                                ->label('Tipo')
                                ->relationship('memoryType', 'description')
                                ->createOptionForm(self::memory_type_schema())
                                ->live(onBlur: true)
                                ->afterStateUpdated(fn (Get $get, Set $set) => self::get_ram_name($get, $set))
                                ->searchable()
                                ->preload()
                                ->required(),
                            TextInput::make('latency')
                                ->label('Latencia')
                                ->suffix('ns')
                                ->maxLength(255),
                        ])
                        ->columns(2),
                    Step::make('Información Adicional')
                        ->schema([
                            FileUpload::make('image_url')
                                ->label('Imagen')
                                ->image()
                                ->directory('rams_img')
                                ->optimize('webp')
                                ->resize(50),
                            TextInput::make('specifications_link')
                                ->label('Link de especificaciones')
                                ->suffixIcon('heroicon-m-globe-alt')
                                ->maxLength(255),
                            TiptapEditor::make('description')
                                ->label('Descripción')
                                ->columnSpanFull(),
                        ]),
                ])
                ->skippable()
                ->columnSpanFull(),
        ];
    }

    protected static function get_ram_name(Get $get, Set $set): void
    {
        if (!empty($get('brand_id')) && !empty($get('speed')) && !empty($get('capacity')) && !empty($get('ram_form_factor_id')) && !empty($get('memory_type_id'))) {
            $brand = ucfirst(Brand::find($get('brand_id'))->name);
            $speed = $get('speed');
            $capacity = $get('capacity');
            $ram_form_factory = RamFormFactor::find($get('ram_form_factor_id'))->description;
            $memory_type = MemoryType::find($get('memory_type_id'))->description;
            $name = "$brand $ram_form_factory $memory_type $speed MHz $capacity GB";
            $set('name', $name);
        }
    }
}
