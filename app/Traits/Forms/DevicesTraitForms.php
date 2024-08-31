<?php

namespace App\Traits\Forms;

use App\Models;
use Filament\Forms;
use FilamentTiptapEditor\TiptapEditor;
use Illuminate\Database\Eloquent\Builder;

trait DevicesTraitForms
{
    use TraitForms, UserForms;

    /**
     * DeviceStateResource
     */
    protected static function device_state_form(Forms\Form $form): Forms\Form
    {
        return $form->schema(self::device_state_schema());
    }

    protected static function device_state_schema(): array
    {
        return [
            Forms\Components\TextInput::make('name')
                ->hiddenLabel()
                ->placeholder('Nombre')
                ->columnSpanFull()
                ->required()
                ->maxLength(255),
        ];
    }

    /**
     * StorageResourcec
     */
    protected static function storage_form(Forms\Form $form): Forms\Form
    {
        return $form->schema(self::storage_schema());
    }

    protected static function storage_schema(): array
    {
        return [
            Forms\Components\Wizard::make()
                ->columnSpanFull()
                ->skippable()
                ->columns(2)
                ->schema([
                    Forms\components\wizard\Step::make('Nombre')
                        ->schema([
                            Forms\Components\TextInput::make('name')
                                ->label('Nombre')
                                ->disabled(fn(Forms\Get  $get) => $get('auto_name') ? true : false)
                                ->dehydrated()
                                ->live(onBlur: true)
                                ->afterStateUpdated(fn(Forms\Get  $get, Forms\Set $set) => self::get_storage_name($get, $set))
                                ->required()
                                ->maxLength(255),
                            Forms\Components\TextInput::make('slug')
                                ->disabled()
                                ->dehydrated()
                                ->required()
                                ->maxLength(255),
                            Forms\Components\Select::make('type')
                                ->label('Tipo')
                                ->helperText('Tipo de almacenamiento (SSD o HDD)')
                                ->options([
                                    'SSD' => 'SSD',
                                    'HDD' => 'HDD',
                                ])
                                ->native(false)
                                ->searchable()
                                ->required(fn(Forms\Get  $get) => $get('auto_name') ? true : false),
                            Forms\Components\Select::make('brand_id')
                                ->label('Marca')
                                ->relationship('brand', 'name')
                                ->searchable()
                                ->live(onBlur: true)
                                ->afterStateUpdated(fn(Forms\Get  $get, Forms\Set $set) => self::get_storage_name($get, $set))
                                ->preload()
                                ->native(false)
                                ->createOptionForm(self::brand_schema())
                                ->required(fn(Forms\Get  $get) => $get('auto_name') ? true : false),
                            Forms\Components\TextInput::make('model')
                                ->label('Modelo')
                                ->helperText('Nombre del modelo del dispositivo')
                                ->live(onBlur: true)
                                ->afterStateUpdated(fn(Forms\Get  $get, Forms\Set $set) => self::get_storage_name($get, $set))
                                ->maxLength(255)
                                ->required(fn(Forms\Get  $get) => $get('auto_name') ? true : false),
                            Forms\Components\TextInput::make('capacity')
                                ->label('Capacidad')
                                ->helperText(' Capacidad de almacenamiento (e.g., 500GB, 1TB).')
                                ->live(onBlur: true)
                                ->afterStateUpdated(fn(Forms\Get  $get, Forms\Set $set) => self::get_storage_name($get, $set))
                                ->maxLength(255)
                                ->required(fn(Forms\Get  $get) => $get('auto_name') ? true : false),
                            Forms\Components\Select::make('interface')
                                ->label('Interfaz')
                                ->options(self::$interfaces)
                                ->helperText('Tipo de interfaz (e.g., SATA, NVMe)')
                                ->live(onBlur: true)
                                ->afterStateUpdated(fn(Forms\Get  $get, Forms\Set $set) => self::get_storage_name($get, $set))
                                ->searchable()
                                ->required(fn(Forms\Get  $get) => $get('auto_name') ? true : false),
                            Forms\Components\Select::make('form_factor')
                                ->label('Factor de forma')
                                ->helperText('Factor de forma del dispositivo (e.g., 2.5", 3.5", M.2)')
                                ->live(onBlur: true)
                                ->afterStateUpdated(fn(Forms\Get  $get, Forms\Set $set) => self::get_storage_name($get, $set))
                                ->native(false)
                                ->searchable()
                                ->options(self::$form_factor)
                                ->required(fn(Forms\Get  $get) => $get('auto_name') ? true : false),
                            Forms\Components\ToggleButtons::make('auto_name')
                                ->label('Generar Automáticamente el nombre?')
                                ->columnSpanFull()
                                ->helperText('Por lo general el algoritmo generará el nombre, pero si no se genera correctamente al estar fuera de nomenclaturas, puedes desactivar esta opcion para indicar el nombre manualmente')
                                ->inline()
                                ->live()
                                ->default(true)
                                ->boolean(),
                        ]),
                    Forms\components\wizard\Step::make('Información Adicional')
                        ->schema([
                            Forms\Components\TextInput::make('read_speed')
                                ->numeric(),
                            Forms\Components\TextInput::make('write_speed')
                                ->numeric(),
                            Forms\Components\TextInput::make('specs_link')
                                ->maxLength(255),
                        ]),
                ])


        ];
    }

    /**
     * MotherboardResource
     */
    protected static function motherboard_form(Forms\Form $form): Forms\Form
    {
        return $form->schema(self::motherboard_schema());
    }

    protected static function motherboard_schema(): array
    {
        return [
            Forms\Components\Wizard::make()
                ->columnSpanFull()
                ->skippable()
                ->schema([
                    Forms\components\wizard\Step::make('Nombre')
                        ->columns(2)
                        ->schema([
                            Forms\Components\TextInput::make('name')
                                ->disabled(fn(Forms\Get  $get) => $get('auto_name') ? true : false)
                                ->dehydrated()
                                ->label('Nombre')
                                ->live(onBlur: true)
                                ->afterStateUpdated(fn(Forms\Get  $get, Forms\Set $set) => self::get_motherboard_name($get, $set))
                                ->required()
                                ->maxLength(255),
                            Forms\Components\TextInput::make('slug')
                                ->disabled()
                                ->dehydrated()
                                ->required()
                                ->maxLength(255),
                            Forms\Components\Select::make('brand_id')
                                ->label('Marca')
                                ->searchable()
                                ->preload()
                                ->live(onBlur: true)
                                ->required(fn(Forms\Get  $get) => $get('auto_name') ? true : false)
                                ->afterStateUpdated(fn(Forms\Get  $get, Forms\Set $set) => self::get_motherboard_name($get, $set))
                                ->native(false)
                                ->createOptionForm(self::brand_schema())
                                ->relationship('brand', 'name'),
                            Forms\Components\TextInput::make('model')
                                ->label('Modelo')
                                ->live(onBlur: true)
                                ->required(fn(Forms\Get  $get) => $get('auto_name') ? true : false)
                                ->afterStateUpdated(fn(Forms\Get  $get, Forms\Set $set) => self::get_motherboard_name($get, $set))
                                ->helperText('Nombre del modelo (e.g., TOMAHAWK)')
                                ->maxLength(255),
                            Forms\Components\TextInput::make('form_factor')
                                ->label('Factor de forma')
                                ->live(onBlur: true)
                                ->required(fn(Forms\Get  $get) => $get('auto_name') ? true : false)
                                ->afterStateUpdated(fn(Forms\Get  $get, Forms\Set $set) => self::get_motherboard_name($get, $set))
                                ->helperText('Tipo de factor de forma (e.g., ATX, Micro ATX, Mini ITX)s')
                                ->maxLength(255),
                            Forms\Components\TextInput::make('socket')
                                ->label('Zócalo')
                                ->live(onBlur: true)
                                ->required(fn(Forms\Get  $get) => $get('auto_name') ? true : false)
                                ->afterStateUpdated(fn(Forms\Get  $get, Forms\Set $set) => self::get_motherboard_name($get, $set))
                                ->helperText(' Tipo de socket del procesador (e.g., AM4, LGA 1200)')
                                ->maxLength(255),
                            Forms\Components\TextInput::make('chipset')
                                ->live(onBlur: true)
                                ->required(fn(Forms\Get  $get) => $get('auto_name') ? true : false)
                                ->afterStateUpdated(fn(Forms\Get  $get, Forms\Set $set) => self::get_motherboard_name($get, $set))
                                ->label('Chipset')
                                ->helperText('Tipo de chipset (e.g., B450, Z490)')
                                ->maxLength(255),
                            Forms\Components\ToggleButtons::make('auto_name')
                                ->label('Generar Automáticamente el nombre?')
                                ->columnSpanFull()
                                ->helperText('Por lo general el algoritmo generará correctamente el nombre de la placa madre en base a las nomenclaturas, pero si no sucede así, puedes desactivar esta opción para indicarla manualmente')
                                ->inline()
                                ->live()
                                ->default(true)
                                ->boolean(),
                        ]),
                    Forms\components\wizard\Step::make('Información adicional')
                        ->columns(2)
                        ->schema([
                            Forms\Components\TextInput::make('expansion_slots')
                                ->label('Ranuras de expansión')
                                ->helperText('Información sobre las ranuras de expansión (e.g., PCIe x16, PCIe x1)')
                                ->maxLength(255),
                            Forms\Components\TextInput::make('io_ports')
                                ->label('Puertos de E/S')
                                ->helperText('Información sobre los puertos de entrada/salida (e.g., USB 3.0, HDMI, Ethernet)')
                                ->maxLength(255),
                            Forms\Components\TextInput::make('features')->label('Puertos de E/S')
                                ->label('Características adicionales')
                                ->helperText(' Cualquier característica adicional relevante (e.g., soporte para RGB, WiFi integrado)')
                                ->maxLength(255),
                            Forms\Components\TextInput::make('specs_link')
                                ->label('Link de especificaciones')
                                ->suffixIcon('heroicon-m-globe-alt')
                                ->helperText('Puede ingresar el link de especificaciones de la página oficial del fabricante')
                        ]),
                ])
        ];
    }

    /**
     * GraphicSufixResource
     */
    protected static function graphic_sufix_form(Forms\Form $form): Forms\Form
    {
        return $form->schema(self::graphic_sufix_schema());
    }

    protected static function graphic_sufix_schema(): array
    {
        return [
            Forms\Components\TextInput::make('name')
                ->label('Nombre')
                ->required()
                ->maxLength(255),
            Forms\Components\TextInput::make('description')
                ->label('Descripción')
                ->maxLength(255),
            Forms\Components\Select::make('priority')
                ->label('Prioridad')
                ->options([
                    '1' => 1,
                    '2' => 2,
                    '3' => 3,
                    '4' => 4,
                    '5' => 5,
                    '6' => 6,
                ])
                ->required(),
            Forms\Components\Select::make('graphic_manufacturer_id')
                ->relationship('graphicManufacturer', 'name')
                ->searchable()
                ->preload()
                ->native(false)
                ->createOptionForm(self::graphic_manufacturer_schema())
                ->required(),
        ];
    }

    /**
     * GraphicSerieResource
     */
    protected static function graphic_serie_form(Forms\Form $form): Forms\Form
    {
        return $form->schema(self::graphic_serie_schema());
    }

    protected static function graphic_serie_schema(): array
    {
        return [
            Forms\Components\TextInput::make('name')
                ->label('Nombre')
                ->required()
                ->maxLength(255),
            Forms\Components\TextInput::make('prefix')
                ->label('Prefijo')
                ->required()
                ->maxLength(255),
            Forms\Components\Select::make('graphic_manufacturer_id')
                ->label('Fabricante')
                ->relationship('graphicManufacturer', 'name')
                ->createOptionForm(self::graphic_manufacturer_schema())
                ->searchable()
                ->preload()
                ->native(false)
                ->required(),
        ];
    }

    /**
     * GraphicManufacturerResource
     */
    protected static function graphic_manufacturer_form(Forms\Form $form): Forms\Form
    {
        return $form->schema(self::graphic_manufacturer_schema());
    }

    protected static function graphic_manufacturer_schema(): array
    {
        return [
            Forms\Components\TextInput::make('name')
                ->label('Nombre')
                ->columnSpanFull()
                ->required()
                ->maxLength(255),
        ];
    }

    /**
     * ProcessorSeriResource
     */
    protected static function processor_serie_form(Forms\Form $form): Forms\Form
    {
        return $form->schema(self::processor_serie_schema());
    }

    protected static function processor_serie_schema(): array
    {
        return [
            Forms\Components\TextInput::make('name')
                ->label('Nombre')
                ->required()
                ->maxLength(255),
            Forms\Components\Select::make('processor_manufacturer_id')
                ->label('Fabricante')
                ->relationship('processorManufacturer', 'name')
                ->preload()
                ->searchable()
                ->native(false)
                ->required(),
        ];
    }

    /**
     * ProcessorGenerationResource
     */
    protected static function processor_generation_form(Forms\Form $form): Forms\Form
    {
        return $form->schema(self::processor_generation_schema());
    }

    protected static function processor_generation_schema(): array
    {
        return [
            Forms\Components\TextInput::make('name')
                ->label('Nombre')
                ->required()
                ->maxLength(255),
            Forms\Components\TextInput::make('slug')
                ->required()
                ->maxLength(255),
            Forms\Components\TextInput::make('prefix')
                ->label('Prefijo')
                ->required()
                ->maxLength(255),
            Forms\Components\TextInput::make('key_name')
                ->label('Microarquitectura')
                ->maxLength(255),
            Forms\Components\TextInput::make('year')
                ->label('Año'),
            Forms\Components\Select::make('processor_manufacturer_id')
                ->label('Fabricante')
                ->relationship('processorManufacturer', 'name')
                // ->options(ProcessorManufacturerEnum::class)
                ->preload()
                ->searchable()
                ->createOptionForm(self::processor_manufacturer_schema())
                ->native(false)
        ];
    }

    /**
     * ProcessorSufixResource
     */
    protected static function processor_sufix_form(Forms\Form $form): Forms\Form
    {
        return $form->schema(self::processor_sufix_schema());
    }

    protected static function processor_sufix_schema(): array
    {
        return [
            Forms\Components\TextInput::make('name')
                ->label('Sufijo')
                ->required()
                ->maxLength(255),
            Forms\Components\TextInput::make('description')
                ->label('Descripcion')
                ->maxLength(255),
            Forms\Components\Select::make('processor_manufacturer_id')
                ->relationship('processor_manufacturer', 'name')
                ->label('Fabricante')
                ->preload()
                ->searchable()
                ->native(false)
                ->createOptionForm(self::processor_manufacturer_schema())
                ->required(),
        ];
    }

    /**
     * ProcessorManufacturerResource
     */
    protected static function processor_manufacturer_form(Forms\Form $form): Forms\Form
    {
        return $form->schema(self::processor_manufacturer_schema());
    }

    protected static function processor_manufacturer_schema(): array
    {
        return [
            Forms\Components\TextInput::make('name')
                ->label('Nombre')
                ->required()
                ->maxLength(255),
        ];
    }

    /**
     * OperatingSystemResource
     */
    protected static function operating_system_form(Forms\Form $form): Forms\Form
    {
        return $form->schema(self::operating_system_schema());
    }

    protected static function operating_system_schema(): array
    {
        return [
            Forms\Components\TextInput::make('description')
                ->label('Nombre')
                ->required()
                ->maxLength(255),
            Forms\Components\FileUpload::make('image_url')
                ->label('Imagen')
                ->image()
                ->directory('operating_system_files')
                ->optimize('webp')
                ->resize(50),
        ];
    }

    /**
     * GraphicResource
     */
    protected static function graphics_form(Forms\Form $form): Forms\Form
    {
        return $form->schema(self::graphics_schema());
    }

    protected static function graphics_schema(): array
    {
        return [
            Forms\Components\Wizard::make()
                ->columnSpanFull()
                ->skippable()
                ->schema([
                    Forms\components\wizard\Step::make('Nombre')
                        ->columns(2)
                        ->schema([
                            Forms\Components\TextInput::make('name')
                                ->required()
                                ->disabled(fn(Forms\Get  $get) => $get('auto_name') ? true : false)
                                ->dehydrated(),
                            Forms\Components\TextInput::make('slug')
                                ->required()
                                ->disabled()
                                ->dehydrated(),
                            Forms\Components\Select::make('graphic_manufacturer_id')
                                ->relationship('graphicManufacturer', 'name')
                                ->required(fn(Forms\Get  $get) => $get('auto_name') ? true : false)
                                ->label('Fabricante')
                                ->live()
                                ->afterStateUpdated(fn(Forms\Get  $get, Forms\Set $set) => self::get_graphic_name($get, $set))
                                ->preload()
                                ->createOptionForm(self::graphic_manufacturer_schema())
                                ->searchable(),
                            Forms\Components\Select::make('graphic_serie_id')
                                ->label('Sufijo')
                                ->relationship(
                                    name: 'graphicSerie',
                                    modifyQueryUsing: fn(Builder $query, Forms\Get  $get) => $query->where('graphic_manufacturer_id', $get('graphic_manufacturer_id'))
                                )
                                ->getOptionLabelFromRecordUsing(fn(Models\GraphicSerie $record) => "$record->name - [Prefijo: $record->prefix]")
                                ->createOptionForm(self::graphic_serie_schema())
                                ->label('Serie')
                                ->live()
                                ->required(fn(Forms\Get  $get) => $get('auto_name') ? true : false)
                                ->afterStateUpdated(fn(Forms\Get  $get, Forms\Set $set) => self::get_graphic_name($get, $set))
                                ->preload()
                                ->searchable(),
                            Forms\Components\TextInput::make('model')
                                ->label('Modelo')
                                ->live()
                                ->required(fn(Forms\Get  $get) => $get('auto_name') ? true : false)
                                ->afterStateUpdated(fn(Forms\Get  $get, Forms\Set $set) => self::get_graphic_name($get, $set))
                                ->maxLength(255),
                            Forms\Components\Select::make('graphic_sufix_id')
                                ->label('Sufijo')
                                ->required(fn(Forms\Get  $get) => $get('auto_name') ? true : false)
                                ->relationship(
                                    name: 'graphicSufix',
                                    titleAttribute: 'name',
                                    modifyQueryUsing: fn(Builder $query, Forms\Get  $get) => $query->where('graphic_manufacturer_id', $get('graphic_manufacturer_id'))
                                )
                                ->getOptionLabelFromRecordUsing(fn(Models\GraphicSufix $record) => "$record->name - [$record->description]")
                                ->searchable()
                                ->live()
                                ->afterStateUpdated(fn(Forms\Get  $get, Forms\Set $set) => self::get_graphic_name($get, $set))
                                ->createOptionForm(self::graphic_sufix_schema())
                                ->preload()
                                ->multiple()
                                ->native(false),
                            Forms\Components\ToggleButtons::make('auto_name')
                                ->label('Generar Automáticamente el nombre?')
                                ->columnSpanFull()
                                ->helperText('Para Tarjetas gráficas modernas, el algoritmo generará automáticamente los nombres, pero si son antiguos o están fuera de las nomenclaturas, desactiva esta opción para indicarlo manualmente')
                                ->inline()
                                ->live()
                                ->default(true)
                                ->boolean(),
                        ]),
                    Forms\components\wizard\Step::make('Datos Adicionales')
                        ->columns(2)
                        ->schema([
                            Forms\Components\TextInput::make('clock')
                                ->label('Velocidad de Reloj')
                                ->maxLength(255),
                            Forms\Components\TextInput::make('memory_capacity')
                                ->label('Capacidad de la memoria')
                                ->maxLength(255),
                            Forms\Components\TextInput::make('specifications_url')
                                ->label('Link de especificaciones')
                                ->prefixIcon('')
                                ->maxLength(255),
                            Forms\Components\Select::make('memory_type_id')
                                ->label('Tipo de memoria')
                                ->relationship('memoryType', 'description')
                                ->createOptionForm(self::memory_type_schema())
                                ->searchable()
                                ->preload(),
                            Forms\Components\FileUpload::make('image_url')
                                ->columnSpanFull()
                                ->label('Imagen')
                                ->optimize('webp')
                                ->resize(50)
                                ->directory('graphics_img')
                                ->image(),
                        ])
                ])
        ];
    }

    /**
     * PeripheralResource
     */
    protected static function peripheral_form(Forms\Form $form): Forms\Form
    {
        return $form->schema(self::peripheral_schema());
    }

    protected static function peripheral_schema(): array
    {
        return [
            Forms\Components\TextInput::make('name')
                ->label('Nombre')
                ->required()
                ->maxLength(255),
            Forms\Components\Select::make('brand_id')
                ->relationship('brand', 'name')
                ->createOptionForm(self::brand_schema())
                ->searchable()
                ->label('Marca')
                ->preload()
                ->required(),
            Forms\Components\Select::make('peripheral_type_id')
                ->label('Tipo de Periférico')
                ->relationship('peripheralType', 'name')
                ->createOptionForm(self::peripheral_type_schema())
                ->searchable()
                ->native(false)
                ->preload()
                ->required(),
            Forms\Components\FileUpload::make('image_url')
                ->columnSpanFull()
                ->label('Imagen')
                ->optimize('webp')
                ->directory('peripheral_img')
                ->resize(50)
                ->image(),
        ];
    }

    /**
     * PeripheralTypeResource
     */
    protected static function peripheral_type_form(Forms\Form $form): Forms\Form
    {
        return $form->schema(self::peripheral_type_schema());
    }

    protected static function peripheral_type_schema(): array
    {
        return [
            Forms\Components\TextInput::make('name')
                ->unique(ignoreRecord: true)
                ->label('Nombre')
                ->live(onBlur: true)
                ->afterStateUpdated(fn(Forms\Contracts\HasForms $livewire, Forms\Components\TextInput $componente) => self::validate_one_field($livewire, $componente))
                ->columnSpanFull()
                ->required()
                ->maxLength(255),
        ];
    }

    /**
     * RamResource
     */
    protected static function ram_form(Forms\Form $form): Forms\Form
    {
        return $form->schema(self::ram_schema());
    }

    protected static function ram_schema(): array
    {
        return [
            Forms\Components\Wizard::make()
                ->schema([
                    Forms\components\wizard\Step::make('Información Principal')
                        ->schema([
                            Forms\Components\TextInput::make('name')
                                ->label('Nombre')
                                ->disabled()
                                ->dehydrated()
                                ->columnSpanFull()
                                ->helperText(str('El nombre se creará a partir de los campos con asterisco (*)')->inlineMarkdown()->toHtmlString())
                                ->required(),
                            Forms\Components\Select::make('brand_id')
                                ->label('Marca')
                                ->relationship('brand', 'name')
                                ->live(onBlur: true)
                                ->afterStateUpdated(fn(Forms\Get  $get, Forms\Set $set) => self::get_ram_name($get, $set))
                                ->createOptionForm(self::brand_schema())
                                ->searchable()
                                ->preload()
                                ->required(),
                            Forms\Components\TextInput::make('speed')
                                ->label('Velocidad')
                                ->suffix('GHz')
                                ->integer()
                                ->live(onBlur: true)
                                ->afterStateUpdated(fn(Forms\Get  $get, Forms\Set $set) => self::get_ram_name($get, $set))
                                ->required()
                                ->maxLength(255),
                            Forms\Components\TextInput::make('capacity')
                                ->label('Capacidad de la memoria')
                                ->numeric()
                                ->integer()
                                ->live(onBlur: true)
                                ->afterStateUpdated(fn(Forms\Get  $get, Forms\Set $set) => self::get_ram_name($get, $set))
                                ->suffix('GB')
                                ->required()
                                ->maxLength(255),
                            Forms\Components\Select::make('ram_form_factor_id')
                                ->label('Factor de Forma')
                                ->relationship('ramFormFactor', 'description')
                                ->createOptionForm(self::ram_form_factor_schema())
                                ->live(onBlur: true)
                                ->afterStateUpdated(fn(Forms\Get  $get, Forms\Set $set) => self::get_ram_name($get, $set))
                                ->searchable()
                                ->preload()
                                ->required(),
                            Forms\Components\Select::make('memory_type_id')
                                ->label('Tipo')
                                ->relationship('memoryType', 'description')
                                ->createOptionForm(self::memory_type_schema())
                                ->live(onBlur: true)
                                ->afterStateUpdated(fn(Forms\Get  $get, Forms\Set $set) => self::get_ram_name($get, $set))
                                ->searchable()
                                ->preload()
                                ->required(),
                            Forms\Components\TextInput::make('latency')
                                ->label('Latencia')
                                ->suffix('ns')
                                ->maxLength(255),
                        ])
                        ->columns(2),
                    Forms\components\wizard\Step::make('Información Adicional')
                        ->schema([
                            Forms\Components\FileUpload::make('image_url')
                                ->label('Imagen')
                                ->image()
                                ->directory('rams_img')
                                ->optimize('webp')
                                ->resize(50),
                            Forms\Components\TextInput::make('specifications_link')
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

    /**
     * ProcessorResource
     */
    protected static function proccessor_form(Forms\Form $form): Forms\Form
    {
        return $form->schema(self::proccessor_schema());
    }

    protected static function proccessor_schema(): array
    {
        return [
            Forms\Components\Wizard::make()
                ->columnSpanFull()
                ->skippable()
                ->schema([
                    Forms\components\wizard\Step::make('Nombre')
                        ->columns(2)
                        ->schema([
                            Forms\Components\TextInput::make('name')
                                ->label('Nombre')
                                ->required()
                                ->disabled(fn(Forms\Get  $get) => $get('auto_name') ? true : false)
                                ->live(onBlur: true)
                                ->afterStateUpdated(fn(Forms\Get  $get, Forms\Set $set) => self::get_processor_name($get, $set))
                                ->dehydrated()
                                ->helperText('El nombre y el slug se generan en base al modelo, generación, serie, sufijo, y fabricante')
                                ->maxLength(255),
                            Forms\Components\TextInput::make('slug')
                                ->disabled()
                                ->dehydrated()
                                ->required()
                                ->maxLength(255),
                            Forms\Components\Select::make('processor_manufacturer_id')
                                ->label('Fabricante')
                                ->required(fn(Forms\Get  $get) => $get('auto_name') ? true : false)
                                ->native(false)
                                ->searchable()
                                ->createOptionForm(self::processor_manufacturer_schema())
                                ->relationship('processorManufacturer', 'name')
                                ->helperText('Al seleccionar un fabricante apareceran las series y sufijos correspondientes')
                                ->live(onBlur: true)
                                ->afterStateUpdated(fn(Forms\Get  $get, Forms\Set $set) => self::get_processor_name($get, $set))
                                ->preload(),
                            Forms\Components\Select::make('processor_serie_id')
                                ->label('Serie')
                                ->required(fn(Forms\Get  $get) => $get('auto_name') ? true : false)
                                ->searchable()
                                ->relationship(
                                    name: 'processorSerie',
                                    titleAttribute: 'name',
                                    modifyQueryUsing: fn(Builder $query, Forms\Get  $get) => $query->where('processor_manufacturer_id', $get('processor_manufacturer_id'))->orderBy('name')
                                )
                                ->live(onBlur: true)
                                ->createOptionForm(self::processor_serie_schema())
                                ->afterStateUpdated(fn(Forms\Get  $get, Forms\Set $set) => self::get_processor_name($get, $set))
                                ->preload(),
                            Forms\Components\Select::make('processor_generation_id')
                                ->label('Generación')
                                ->relationship(
                                    name: 'processorGeneration',
                                    titleAttribute: 'name',
                                    modifyQueryUsing: fn(Builder $query, Forms\Get  $get) => $query->where('processor_manufacturer_id', $get('processor_manufacturer_id'))
                                )
                                ->live(onBlur: true)
                                ->createOptionForm(self::processor_generation_schema())
                                ->afterStateUpdated(fn(Forms\Get  $get, Forms\Set $set) => self::get_processor_name($get, $set))
                                ->native(false)
                                ->required(fn(Forms\Get  $get) => $get('auto_name') ? true : false)
                                ->searchable()
                                ->preload(),
                            Forms\Components\TextInput::make('model')
                                ->label('Modelo')
                                ->required(fn(Forms\Get  $get) => $get('auto_name') ? true : false)
                                ->afterStateUpdated(fn(Forms\Get  $get, Forms\Set $set) => self::get_processor_name($get, $set))
                                ->live(onBlur: true)
                                ->helperText('Es el número luego de la generación')
                                ->maxLength(255),
                            Forms\Components\Select::make('processor_sufix_id')
                                ->label('Sufijo')
                                ->relationship(
                                    name: 'processorSufix',
                                    titleAttribute: 'name',
                                    modifyQueryUsing: fn(Builder $query, Forms\Get  $get) => $query->where('processor_manufacturer_id', $get('processor_manufacturer_id'))
                                )
                                ->searchable()
                                ->getOptionLabelFromRecordUsing(fn(Models\ProcessorSufix $record) => "$record->name - [" . self::get_sufix_description($record->description) . "]")
                                ->createOptionForm(self::processor_sufix_schema())
                                ->preload()
                                ->live(onBlur: true)
                                ->afterStateUpdated(fn(Forms\Get  $get, Forms\Set $set) => self::get_processor_name($get, $set)),
                            Forms\Components\ToggleButtons::make('auto_name')
                                ->label('Generar Automáticamente el nombre?')
                                ->columnSpanFull()
                                ->helperText('Para procesadores modernos, el algoritmo generará automáticamente los nombres, pero si son antiguos o están fuera de las nomenclaturas modernas, desactiva esta opción para indicarlo manualmente')
                                ->inline()
                                ->live()
                                ->default(true)
                                ->boolean(),
                        ]),
                    Forms\components\wizard\Step::make('Información Adicional')
                        ->columns(2)
                        ->description('Los datos de esta sección son opcionales pero importantes')
                        ->schema([
                            Forms\Components\TextInput::make('cores')
                                ->label('Nucleos')
                                ->numeric()
                                ->integer()
                                ->maxLength(255),
                            Forms\Components\TextInput::make('threads')
                                ->label('Hilos')
                                ->numeric()
                                ->integer()
                                ->maxLength(255),
                            Forms\Components\TextInput::make('socket')
                                ->label('Socket')
                                ->maxLength(255),
                            Forms\Components\TextInput::make('tdp')
                                ->label('T.D.P.')
                                ->maxLength(255),
                            Forms\Components\TextInput::make('integrated_graphics')
                                ->label('Gráficos Integrados')
                                ->maxLength(255),
                            Forms\Components\Select::make('memory_type_id')
                                ->label('Tipo de memoria Ram')
                                ->relationship('memoryType', 'description')
                                ->createOptionForm(self::memory_type_schema())
                                ->searchable()
                                ->preload(),
                            Forms\Components\TextInput::make('memory_capacity')
                                ->label('Total de memoria Ram')
                                ->maxLength(255),
                            Forms\Components\Select::make('processor_condition_id')
                                ->label('Condición del procesador')
                                ->relationship('processorCondition', 'description')
                                ->createOptionForm(self::processor_condition_schema())
                                ->searchable()
                                ->preload(),
                            Forms\Components\TextInput::make('specifications_url')
                                ->label('Link de especificaciones')
                                ->helperText('Si tienes el link de las especificaciones del procesador, las puedes guardar aquí para acceder más rápidamente.')
                                ->suffixIcon('heroicon-m-globe-alt')
                                ->columnSpanFull()
                                ->url(),
                            Forms\Components\FileUpload::make('image_url')
                                ->label('Imagen')
                                ->columnSpanFull()
                                ->optimize('webp')
                                ->resize(50)
                                ->directory('processor_img')
                                ->image(),
                            TiptapEditor::make('description')
                                ->columnSpanFull(),
                        ]),
                ])
        ];
    }

    /**
     * Métodos adicionales
     */

    protected static function get_ram_name(Forms\Get  $get, Forms\Set $set): void
    {
        $brandId = $get('brand_id');
        $speed = $get('speed');
        $capacity = $get('capacity');
        $ramFormFactorId = $get('ram_form_factor_id');
        $memoryTypeId = $get('memory_type_id');

        if (!empty($brandId) && !empty($speed) && !empty($capacity) && !empty($ramFormFactorId) && !empty($memoryTypeId)) {
            $brand = ucfirst(optional(Models\Brand::find($brandId))->name);
            $ramFormFactor = optional(Models\RamFormFactor::find($ramFormFactorId))->description;
            $memoryType = optional(Models\MemoryType::find($memoryTypeId))->description;

            $name = self::buildRamName($brand, $ramFormFactor, $memoryType, $speed, $capacity);
            $set('name', $name);
        }
    }

    private static function buildRamName(string $brand, string $ramFormFactor, string $memoryType, string $speed, string $capacity): string
    {
        return trim("$brand $ramFormFactor $memoryType $speed MHz $capacity GB");
    }

    protected static function get_processor_name(Forms\Get  $get, Forms\Set $set): void
    {
        if ($get('auto_name')) {
            $processorManufacturerId = $get('processor_manufacturer_id');
            $model = $get('model');
            $processorSerieId = $get('processor_serie_id');
            $processorGenerationId = $get('processor_generation_id');
            $processorSufixId = $get('processor_sufix_id');

            if (!is_null($processorManufacturerId) && !is_null($model) && !is_null($processorSerieId) && !is_null($processorGenerationId)) {
                $manufacturer = optional(Models\ProcessorManufacturer::find($processorManufacturerId))->name;
                $serie = optional(Models\ProcessorSerie::find($processorSerieId))->name;
                $sufijo = $processorSufixId ? strtoupper(optional(Models\ProcessorSufix::find($processorSufixId))->name) : '';
                $generation = optional(Models\ProcessorGeneration::find($processorGenerationId))->prefix;

                $name = self::buildProcessorName($manufacturer, $serie, $generation, $model, $sufijo);
                $set('name', $name);
                $set('slug', \Illuminate\Support\Str::slug($name));
            }
        } else {
            $name = $get('name');
            if (!is_null($name)) {
                $set('slug', \Illuminate\Support\Str::slug($name));
            }
        }
    }

    private static function buildProcessorName(string $manufacturer, string $serie, string $generation, string $model, string $sufijo): string
    {
        return trim("$manufacturer $serie $generation $model $sufijo");
    }

    protected static function get_sufix_description($description): string
    {
        return $description ? $description : 'No hay descripción disponible';
    }

    protected static function get_graphic_name(Forms\Get  $get, Forms\Set $set): void
    {
        if ($get('auto_name')) {
            $graphicManufacturerId = $get('graphic_manufacturer_id');
            $graphicSerieId = $get('graphic_serie_id');
            $model = $get('model');
            $sufixIds = $get('graphic_sufix_id');

            if (!is_null($graphicManufacturerId) && !is_null($graphicSerieId) && !is_null($model) && !is_null($sufixIds)) {
                $manufacturer = ucfirst(optional(Models\GraphicManufacturer::find($graphicManufacturerId))->name);
                $serie = optional(Models\GraphicSerie::find($graphicSerieId))->prefix;

                // Obtener sufijos ordenados
                $orderedSufixes = self::getOrderedSufixes($sufixIds);

                // Concatenar sufijos en un string
                $finalString = implode(' ', $orderedSufixes);

                $name = "$manufacturer $serie $model $finalString";
                $set('name', trim($name));
                $set('slug', \Illuminate\Support\Str::slug(trim($name)));
            }
        } else {
            $name = $get('name');
            if (!is_null($name)) {
                $set('slug', \Illuminate\Support\Str::slug($name));
            }
        }
    }

    private static function getOrderedSufixes(array $sufixIds): array
    {
        $sufixes = [];

        foreach ($sufixIds as $id) {
            $sufix = Models\GraphicSufix::find($id);
            if ($sufix) {
                $sufixes[$sufix->priority][] = $sufix->name;
            }
        }

        // Ordenar sufijos por prioridad
        ksort($sufixes);

        // Crear un array de sufijos concatenados por prioridad
        return array_map(fn($sufixNames) => implode(', ', $sufixNames), $sufixes);
    }

    protected static function get_total_ram(\Filament\Forms\Get $get, \Filament\Forms\Set $set): void
    {
        $selectedRams = collect($get('deviceRams'))
            ->filter(fn($item) => !empty($item['ram_id']) && $item['quantity']);

        $total_ram = $selectedRams->reduce(function ($subtotal, $ram) {
            $ram_capacity = intval(\App\Models\Ram::find($ram['ram_id'])->capacity);
            return $subtotal + ($ram['quantity'] * $ram_capacity);
        }, 0); // Inicializa el subtotal en 0

        $set('ram_total', $total_ram);
    }

    protected static function get_device_name(\Filament\Forms\Get $get, \Filament\Forms\Set $set): void
    {
        $deviceTypeId = $get('device_type_id');
        $customerId = $get('customer_id');

        if (!is_null($deviceTypeId) && !is_null($customerId)) {
            // Obtener el símbolo del dispositivo en mayúsculas
            $deviceDesc = strtoupper(\App\Models\DeviceType::find($deviceTypeId)->symbol);

            // Obtener el número de dispositivos del cliente y rellenar con ceros
            $userDeviceCount = str_pad(\App\Models\Customer::find($customerId)->devices()->count(), 4, '0', STR_PAD_LEFT);

            // Obtener el total de dispositivos en el modelo y rellenar con ceros
            $totalDeviceCount = str_pad(\App\Models\Device::count(), 4, '0', STR_PAD_LEFT);

            // Construir el nombre del dispositivo
            $deviceName = "$deviceDesc-$userDeviceCount-$totalDeviceCount";

            $set('name', $deviceName);
            $set('slug', \Illuminate\Support\Str::slug($deviceName));
        }
    }

    public static function get_motherboard_name(\Filament\Forms\Get $get, \Filament\Forms\Set $set): void
    {
        if ($get('auto_name')) {
            $brandId = $get('brand_id');
            $model = $get('model');
            $formFactor = $get('form_factor');
            $socket = $get('socket');
            $chipset = $get('chipset');

            if (!is_null($brandId) && !is_null($model) && !is_null($formFactor) && !is_null($socket) && !is_null($chipset)) {
                $name = sprintf("%s %s %s %s (%s)", ucfirst($chipset), ucfirst($model), ucfirst($formFactor), $socket);
                $set('name', $name);
                $set('slug', \Illuminate\Support\Str::slug($name));
            }
        } else {
            $name = $get('name');
            if (!is_null($name)) {
                $set('slug', \Illuminate\Support\Str::slug($name));
            }
        }
    }

    protected static function get_storage_name(\Filament\Forms\Get $get, \Filament\Forms\Set $set): void
    {
        if ($get('auto_name')) {
            $brandId = $get('brand_id');
            $model = $get('model');
            $type = $get('type');
            $capacity = $get('capacity');
            $interface = $get('interface');
            $formFactor = $get('form_factor');

            if (!is_null($brandId) && !is_null($model) && !is_null($type) && !is_null($capacity) && !is_null($interface) && !is_null($formFactor)) {
                $brand = ucfirst(\App\Models\Brand::find($brandId)->name);
                $name = sprintf("%s %s (%s, %s, %s)", $brand, $model, $capacity, $interface, $formFactor);
                $set('name', $name);
                $set('slug', \Illuminate\Support\Str::slug($name));
            }
        } else {
            $name = $get('name');
            if (!is_null($name)) {
                $set('slug', \Illuminate\Support\Str::slug($name));
            }
        }
    }

    /**
     * Interfaces
     */

    protected static $interfaces = [
        'SATA I' => 'SATA I',
        'SATA II' => 'SATA II',
        'SATA III' => 'SATA III',
        'NVMe' => 'NVMe',
        'PCIe' => 'PCIe',
        'mSATA' => 'mSSATA',
        'M.2 SATA' => 'M.2 SATA',
        'M.2 NVMe' => 'M.2 NVMe',
        'U.2' => 'U.2',
        'SCSI' => 'SCSI',
        'SAS' => 'SAS',
        'IDE/PATA' => 'IDE/PATA',
    ];

    protected static $form_factor = [
        '3.5"' => '3.5',
        '2.5"' => '2.5',
        'M.2 2280' => 'M.2 2280  (22mm x 80mm)', // 22mm x 80mm
        'M.2 2260' => 'M.2 2260 (22mm x 60mm)', // 22mm x 60mm
        'M.2 2242' => 'M.2 2242 (22mm x 42mm)', // 22mm x 42mm
        'mSATA' => 'mSATA',
        'U.2' => 'U.2',
        'PCIe' => 'PCIe',
    ];
}
