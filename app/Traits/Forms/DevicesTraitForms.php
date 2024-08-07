<?php

namespace App\Traits\Forms;

use App\Enums\ProcessorManufacturerEnum;
use App\Models\Brand;
use App\Models\Customer;
use App\Models\Device;
use App\Models\DeviceType;
use App\Models\GraphicManufacturer;
use App\Models\GraphicSerie;
use App\Models\GraphicSufix;
use App\Models\MemoryType;
use App\Models\Processor;
use App\Models\ProcessorGeneration;
use App\Models\ProcessorManufacturer;
use App\Models\ProcessorSerie;
use App\Models\ProcessorSufix;
use App\Models\Ram;
use App\Models\RamFormFactor;
use App\Models\User;
use Awcodes\TableRepeater\Components\TableRepeater;
use Awcodes\TableRepeater\Header;
use Carbon\Carbon;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use FilamentTiptapEditor\TiptapEditor;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

trait DevicesTraitForms
{
    use TraitForms, UserForms;

    /**
     * DeviceStateResource
     */
    protected static function device_state_form(Form $form): Form
    {
        return $form->schema(self::device_state_schema());
    }

    protected static function device_state_schema(): array
    {
        return [
            TextInput::make('name')
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
    protected static function storage_form(Form $form): Form
    {
        return $form->schema(self::storage_schema());
    }

    protected static function storage_schema(): array
    {
        return [
            Wizard::make()
                ->columnSpanFull()
                ->skippable()
                ->columns(2)
                ->schema([
                    Step::make('Nombre')
                        ->schema([
                            TextInput::make('name')
                                ->label('Nombre')
                                ->disabled(fn (Get $get) => $get('auto_name') ? true : false)
                                ->dehydrated()
                                ->live(onBlur: true)
                                ->afterStateUpdated(fn (Get $get, Set $set) => self::get_storage_name($get, $set))
                                ->required()
                                ->maxLength(255),
                            TextInput::make('slug')
                                ->disabled()
                                ->dehydrated()
                                ->required()
                                ->maxLength(255),
                            Select::make('type')
                                ->label('Tipo')
                                ->helperText('Tipo de almacenamiento (SSD o HDD)')
                                ->options([
                                    'SSD' => 'SSD',
                                    'HDD' => 'HDD',
                                ])
                                ->native(false)
                                ->searchable()
                                ->required(fn (Get $get) => $get('auto_name') ? true : false),
                            Select::make('brand_id')
                                ->label('Marca')
                                ->relationship('brand', 'name')
                                ->searchable()
                                ->live(onBlur: true)
                                ->afterStateUpdated(fn (Get $get, Set $set) => self::get_storage_name($get, $set))
                                ->preload()
                                ->native(false)
                                ->createOptionForm(self::brand_schema())
                                ->required(fn (Get $get) => $get('auto_name') ? true : false),
                            TextInput::make('model')
                                ->label('Modelo')
                                ->helperText('Nombre del modelo del dispositivo')
                                ->live(onBlur: true)
                                ->afterStateUpdated(fn (Get $get, Set $set) => self::get_storage_name($get, $set))
                                ->maxLength(255)
                                ->required(fn (Get $get) => $get('auto_name') ? true : false),
                            TextInput::make('capacity')
                                ->label('Capacidad')
                                ->helperText(' Capacidad de almacenamiento (e.g., 500GB, 1TB).')
                                ->live(onBlur: true)
                                ->afterStateUpdated(fn (Get $get, Set $set) => self::get_storage_name($get, $set))
                                ->maxLength(255)
                                ->required(fn (Get $get) => $get('auto_name') ? true : false),
                            Select::make('interface')
                                ->label('Interfaz')
                                ->options(self::$interfaces)
                                ->helperText('Tipo de interfaz (e.g., SATA, NVMe)')
                                ->live(onBlur: true)
                                ->afterStateUpdated(fn (Get $get, Set $set) => self::get_storage_name($get, $set))
                                ->searchable()
                                ->required(fn (Get $get) => $get('auto_name') ? true : false),
                            Select::make('form_factor')
                                ->label('Factor de forma')
                                ->helperText('Factor de forma del dispositivo (e.g., 2.5", 3.5", M.2)')
                                ->live(onBlur: true)
                                ->afterStateUpdated(fn (Get $get, Set $set) => self::get_storage_name($get, $set))
                                ->native(false)
                                ->searchable()
                                ->options(self::$form_factor)
                                ->required(fn (Get $get) => $get('auto_name') ? true : false),
                            ToggleButtons::make('auto_name')
                                ->label('Generar Automáticamente el nombre?')
                                ->columnSpanFull()
                                ->helperText('Por lo general el algoritmo generará el nombre, pero si no se genera correctamente al estar fuera de nomenclaturas, puedes desactivar esta opcion para indicar el nombre manualmente')
                                ->inline()
                                ->live()
                                ->default(true)
                                ->boolean(),
                        ]),
                    Step::make('Información Adicional')
                        ->schema([
                            TextInput::make('read_speed')
                                ->numeric(),
                            TextInput::make('write_speed')
                                ->numeric(),
                            TextInput::make('specs_link')
                                ->maxLength(255),
                        ]),
                ])


        ];
    }

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

    protected static function get_storage_name(Get $get, Set $set): void
    {
        if ($get('auto_name')) {
            if (!is_null($get('brand_id')) && !is_null($get('model')) && !is_null($get('type')) && !is_null($get('capacity')) && !is_null($get('interface')) && !is_null($get('form_factor'))) {
                $brand = ucfirst(Brand::find($get('brand_id'))->name);
                $model = $get('model');
                $type = $get('type');
                $capacity = $get('capacity');
                $interface = $get('interface');
                $form_factor = $get('form_factor');
                $name = "{$brand} {$model} ({$capacity}, {$interface}, {$form_factor})";
                $set('name', $name);
                $set('slug', Str::slug($name));
            }
        } else {
            if (!is_null($get('name'))) {
                $set('slug', Str::slug($get('name')));
            }
        }
    }

    /**
     * MotherboardResource
     */
    protected static function motherboard_form(Form $form): Form
    {
        return $form->schema(self::motherboard_schema());
    }

    protected static function motherboard_schema(): array
    {
        return [
            Wizard::make()
                ->columnSpanFull()
                ->skippable()
                ->schema([
                    Step::make('Nombre')
                        ->columns(2)
                        ->schema([
                            TextInput::make('name')
                                ->disabled(fn (Get $get) => $get('auto_name') ? true : false)
                                ->dehydrated()
                                ->label('Nombre')
                                ->live(onBlur: true)
                                ->afterStateUpdated(fn (Get $get, Set $set) => self::get_motherboard_name($get, $set))
                                ->required()
                                ->maxLength(255),
                            TextInput::make('slug')
                                ->disabled()
                                ->dehydrated()
                                ->required()
                                ->maxLength(255),
                            Select::make('brand_id')
                                ->label('Marca')
                                ->searchable()
                                ->preload()
                                ->live(onBlur: true)
                                ->required(fn (Get $get) => $get('auto_name') ? true : false)
                                ->afterStateUpdated(fn (Get $get, Set $set) => self::get_motherboard_name($get, $set))
                                ->native(false)
                                ->createOptionForm(self::brand_schema())
                                ->relationship('brand', 'name'),
                            TextInput::make('model')
                                ->label('Modelo')
                                ->live(onBlur: true)
                                ->required(fn (Get $get) => $get('auto_name') ? true : false)
                                ->afterStateUpdated(fn (Get $get, Set $set) => self::get_motherboard_name($get, $set))
                                ->helperText('Nombre del modelo (e.g., TOMAHAWK)')
                                ->maxLength(255),
                            TextInput::make('form_factor')
                                ->label('Factor de forma')
                                ->live(onBlur: true)
                                ->required(fn (Get $get) => $get('auto_name') ? true : false)
                                ->afterStateUpdated(fn (Get $get, Set $set) => self::get_motherboard_name($get, $set))
                                ->helperText('Tipo de factor de forma (e.g., ATX, Micro ATX, Mini ITX)s')
                                ->maxLength(255),
                            TextInput::make('socket')
                                ->label('Zócalo')
                                ->live(onBlur: true)
                                ->required(fn (Get $get) => $get('auto_name') ? true : false)
                                ->afterStateUpdated(fn (Get $get, Set $set) => self::get_motherboard_name($get, $set))
                                ->helperText(' Tipo de socket del procesador (e.g., AM4, LGA 1200)')
                                ->maxLength(255),
                            TextInput::make('chipset')
                                ->live(onBlur: true)
                                ->required(fn (Get $get) => $get('auto_name') ? true : false)
                                ->afterStateUpdated(fn (Get $get, Set $set) => self::get_motherboard_name($get, $set))
                                ->label('Chipset')
                                ->helperText('Tipo de chipset (e.g., B450, Z490)')
                                ->maxLength(255),
                            ToggleButtons::make('auto_name')
                                ->label('Generar Automáticamente el nombre?')
                                ->columnSpanFull()
                                ->helperText('Por lo general el algoritmo generará correctamente el nombre de la placa madre en base a las nomenclaturas, pero si no sucede así, puedes desactivar esta opción para indicarla manualmente')
                                ->inline()
                                ->live()
                                ->default(true)
                                ->boolean(),
                        ]),
                    Step::make('Información adicional')
                        ->columns(2)
                        ->schema([
                            TextInput::make('expansion_slots')
                                ->label('Ranuras de expansión')
                                ->helperText('Información sobre las ranuras de expansión (e.g., PCIe x16, PCIe x1)')
                                ->maxLength(255),
                            TextInput::make('io_ports')
                                ->label('Puertos de E/S')
                                ->helperText('Información sobre los puertos de entrada/salida (e.g., USB 3.0, HDMI, Ethernet)')
                                ->maxLength(255),
                            TextInput::make('features')->label('Puertos de E/S')
                                ->label('Características adicionales')
                                ->helperText(' Cualquier característica adicional relevante (e.g., soporte para RGB, WiFi integrado)')
                                ->maxLength(255),
                            TextInput::make('specs_link')
                                ->label('Link de especificaciones')
                                ->suffixIcon('heroicon-m-globe-alt')
                                ->helperText('Puede ingresar el link de especificaciones de la página oficial del fabricante')
                        ]),
                ])
        ];
    }

    public static function get_motherboard_name(Get $get, Set $set): void
    {
        if ($get('auto_name')) {
            if (!is_null($get('brand_id')) && !is_null($get('model')) && !is_null($get('form_factor')) && !is_null($get('socket')) && !is_null($get('chipset'))) {
                $brand = ucfirst(Brand::find($get('brand_id'))->name);
                $model = ucfirst($get('model'));
                $form_factor = ucfirst($get('form_factor'));
                $socket = $get('socket');
                $chipset = $get('chipset');
                $name = "{$brand} {$chipset} {$model} {$form_factor} ({$socket})";
                $set('name', $name);
                $set('slug', Str::slug($name));
            }
        } else {
            if (!is_null($get('name'))) {
                $set('slug', Str::slug($get('name')));
            }
        }
    }

    /**
     * GraphicSufixResource
     */
    protected static function graphic_sufix_form(Form $form): Form
    {
        return $form->schema(self::graphic_sufix_schema());
    }

    protected static function graphic_sufix_schema(): array
    {
        return [
            TextInput::make('name')
                ->label('Nombre')
                ->required()
                ->maxLength(255),
            TextInput::make('description')
                ->label('Descripción')
                ->maxLength(255),
            Select::make('priority')
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
            Select::make('graphic_manufacturer_id')
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
    protected static function graphic_serie_form(Form $form): Form
    {
        return $form->schema(self::graphic_serie_schema());
    }

    protected static function graphic_serie_schema(): array
    {
        return [
            TextInput::make('name')
                ->label('Nombre')
                ->required()
                ->maxLength(255),
            TextInput::make('prefix')
                ->label('Prefijo')
                ->required()
                ->maxLength(255),
            Select::make('graphic_manufacturer_id')
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
    protected static function graphic_manufacturer_form(Form $form): Form
    {
        return $form->schema(self::graphic_manufacturer_schema());
    }

    protected static function graphic_manufacturer_schema(): array
    {
        return [
            TextInput::make('name')
                ->label('Nombre')
                ->columnSpanFull()
                ->required()
                ->maxLength(255),
        ];
    }

    /**
     * ProcessorSeriResource
     */
    protected static function processor_serie_form(Form $form): Form
    {
        return $form->schema(self::processor_serie_schema());
    }

    protected static function processor_serie_schema(): array
    {
        return [
            TextInput::make('name')
                ->label('Nombre')
                ->required()
                ->maxLength(255),
            Select::make('processor_manufacturer_id')
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
    protected static function processor_generation_form(Form $form): Form
    {
        return $form->schema(self::processor_generation_schema());
    }

    protected static function processor_generation_schema(): array
    {
        return [
            TextInput::make('name')
                ->label('Nombre')
                ->required()
                ->maxLength(255),
            TextInput::make('slug')
                ->required()
                ->maxLength(255),
            TextInput::make('prefix')
                ->label('Prefijo')
                ->required()
                ->maxLength(255),
            TextInput::make('key_name')
                ->label('Microarquitectura')
                ->maxLength(255),
            TextInput::make('year')
                ->label('Año'),
            Select::make('processor_manufacturer_id')
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
                ->createOptionForm(self::processor_manufacturer_schema())
                ->required(),
        ];
    }

    /**
     * ProcessorManufacturerResource
     */
    protected static function processor_manufacturer_form(Form $form): Form
    {
        return $form->schema(self::processor_manufacturer_schema());
    }

    protected static function processor_manufacturer_schema(): array
    {
        return [
            TextInput::make('name')
                ->label('Nombre')
                ->required()
                ->maxLength(255),
        ];
    }

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
            Wizard::make()
                ->schema([
                    Step::make('Información Básica')
                        ->schema([
                            TextInput::make('name')
                                ->disabled()
                                ->dehydrated()
                                ->helperText('El nombre y el slug se crearán automáticamente despues de seleccionar un tipo de dispositivo y el dueño'),
                            TextInput::make('slug')
                                ->disabled()
                                ->dehydrated(),
                            Select::make('motherboard_id')
                                ->label('Placa Madre')
                                ->relationship('motherboard', 'name')
                                ->searchable()
                                ->preload()
                                ->createOptionForm(self::motherboard_schema())
                                ->editOptionForm(self::motherboard_schema())
                                ->columnSpanFull(),
                            Select::make('device_type_id')
                                ->relationship('deviceType', 'description')
                                ->native(false)
                                ->label('Tipo de dispositivo')
                                ->live(onBlur: true)
                                ->afterStateUpdated(fn (Get $get, Set $set) => self::get_device_name($get, $set))
                                ->searchable()
                                ->preload()
                                ->required(),
                            Select::make('customer_id')
                                ->relationship('customer', 'name')
                                ->createOptionForm(self::customer_schema())
                                ->editOptionForm(self::customer_schema())
                                ->native(false)
                                ->label('Dueño')
                                ->live(onBlur: true)
                                ->afterStateUpdated(fn (Get $get, Set $set) => self::get_device_name($get, $set))
                                ->preload()
                                ->searchable()
                                ->required(),
                            Select::make('processor_id')
                                ->relationship('processor', 'name')
                                ->label('Procesador')
                                ->native(false)
                                ->createOptionForm(self::proccessor_schema())
                                ->editOptionForm(self::proccessor_schema())
                                ->searchable()
                                ->preload(),
                            TextInput::make('identifier')
                                ->label('Identificador')
                                ->helperText('Puedes Escribir lo que gustes aquí para poder identificar este dispositivo en otros recursos (ej. Pc de Hijo mayor)'),
                            TextInput::make('ram_total')
                                ->label('Ram total')
                                ->helperText('Se rellena automáticamente dependiendo las memorias registradas en la siguiente sección')
                                ->disabled()
                                ->dehydrated()
                                ->integer()
                                ->numeric(),
                            Select::make('device_state_id')
                                ->label('Estado del dispositivo')
                                ->relationship('deviceState', 'name')
                                ->createOptionForm(self::device_state_schema())
                                ->native(false)
                                ->searchable()
                                ->preload(),
                            FileUpload::make('speccy_snapshot_url')
                                ->downloadable()
                                ->preserveFilenames()
                                ->label('Snaapshot Speccy')
                                ->directory('snapshots')
                                ->getUploadedFileNameForStorageUsing(
                                    function (TemporaryUploadedFile $file): string {
                                        $date = Carbon::now()->format('Ymd_His');
                                        return str($file->getClientOriginalName())->prepend("{$date}-");
                                    }
                                )
                                ->helperText(str('De la aplicación **Speccy** guarda un snapshot en la seccion **file**->**save snapshot** y guardala aquí.')->inlineMarkdown()->toHtmlString())
                                ->columnSpanFull(),
                        ])
                        ->columns(2),
                    Step::make('Componenentes')
                        ->schema([
                            Tabs::make()
                                ->tabs([
                                    Tab::make('Sistemas operativos')
                                        ->schema([
                                            TableRepeater::make('deviceOperatingSystems')
                                                ->relationship()
                                                ->emptyLabel('Aún no hay sistemas operativos registrados')
                                                ->label('Sistemas Operativos')
                                                ->headers([
                                                    Header::make('Sistema Operativo')
                                                ])
                                                ->schema([
                                                    Select::make('operating_system_id')
                                                        ->label('Sistemas operativos')
                                                        ->relationship('operatingSystem', 'description')
                                                        ->native(false)
                                                        ->createOptionForm(self::operating_system_schema())
                                                        ->preload()
                                                        ->required()
                                                        ->searchable()
                                                ])
                                                ->defaultItems(0)
                                                ->columnSpanFull(),
                                        ]),
                                    Tab::make('Almacenamiento')
                                        ->schema([
                                            TableRepeater::make('deviceStorages')
                                                ->relationship()
                                                ->emptyLabel('Aún no hay almacenamientos registrados')
                                                ->label('Almacenamiento')
                                                ->headers([
                                                    Header::make('Almacenamiento'),
                                                    Header::make('Cantidad')
                                                ])
                                                ->schema([
                                                    Select::make('storage_id')
                                                        ->relationship('storage', 'name')
                                                        ->native(false)
                                                        ->createOptionForm(self::storage_schema())
                                                        ->preload()
                                                        ->required()
                                                        ->searchable(),
                                                    TextInput::make('quantity')
                                                        ->minValue(1)
                                                        ->numeric()
                                                        ->integer()
                                                        ->default(1)
                                                ])
                                                ->defaultItems(0)
                                                ->columnSpanFull(),
                                        ]),
                                    Tab::make('Tarjetas Gráficas')
                                        ->schema([
                                            TableRepeater::make('deviceGraphics')
                                                ->label('Tarjetas Gráficas')
                                                ->emptyLabel('Aún no hay tarjetas gráficas registrados')
                                                ->relationship()
                                                ->headers([
                                                    Header::make('Nombre')
                                                ])
                                                ->schema([
                                                    Select::make('graphic_id')
                                                        ->label('Tarjetas gráficas')
                                                        ->relationship('graphic', 'name')
                                                        ->createOptionForm(self::graphics_schema())
                                                        ->preload()
                                                        ->required()
                                                        ->searchable()
                                                ])
                                                ->columnSpanFull()
                                                ->defaultItems(0),
                                        ]),
                                    Tab::make('Periféricos')
                                        ->schema([
                                            TableRepeater::make('devicePeripherals')
                                                ->label('Periféricos')
                                                ->relationship()
                                                ->emptyLabel('Aún no hay periféricos registrados')
                                                ->headers([
                                                    Header::make('Periférico')
                                                ])
                                                ->schema([
                                                    Select::make('peripheral_id')
                                                        ->label('Periféricos')
                                                        ->relationship('peripheral', 'name')
                                                        ->createOptionForm(self::peripheral_schema())
                                                        ->required()
                                                        ->preload()
                                                        ->searchable()
                                                ])
                                                ->defaultItems(0)
                                                ->columnSpanFull(),
                                        ]),
                                    Tab::make('Ram')
                                        ->live()
                                        ->schema([
                                            TableRepeater::make('deviceRams')
                                                ->label('Ram')
                                                ->relationship()
                                                ->afterStateUpdated(fn (Get $get, Set $set) => self::get_total_ram($get, $set))
                                                ->deleteAction(
                                                    fn (Action $action) => $action->after(fn (Get $get, Set $set) => self::get_total_ram($get, $set)),
                                                )
                                                ->emptyLabel('Aún no hay memorias ram registradas')
                                                ->headers([
                                                    Header::make('Ram'),
                                                    Header::make('Cantidad')
                                                ])
                                                ->schema([
                                                    Select::make('ram_id')
                                                        ->relationship('ram', 'name')
                                                        ->createOptionForm(self::ram_schema())
                                                        ->preload()
                                                        ->required()
                                                        ->searchable(),
                                                    TextInput::make('quantity')
                                                        ->label('Cantidad')
                                                        ->numeric()
                                                        ->integer()
                                                        ->required()
                                                        ->integer()
                                                ])
                                                ->defaultItems(0)
                                                ->columnSpanFull()
                                        ])
                                ]),
                        ]),
                    Step::make('Información Adicional')
                        ->schema([
                            TiptapEditor::make('description')
                                ->label('Descripción')
                                ->columnSpanFull(),
                            TiptapEditor::make('aditional_info')
                                ->label('Información adicional')
                                ->columnSpanFull(),
                        ])
                ])
                ->columnSpanFull()
                ->skippable(),
        ];
    }

    protected static function get_total_ram(Get $get, Set $set): void
    {
        $selectedRams = collect($get('deviceRams'))->filter(fn ($item) => !empty($item['ram_id']) && $item['quantity']);
        $total_ram = $selectedRams->reduce(function ($subtotal, $ram) {
            $ram_capacity = intval(Ram::find($ram['ram_id'])->capacity);
            // dd(($ram_capacity));
            return $subtotal + ($ram['quantity'] * $ram_capacity);
        });

        $set('ram_total', $total_ram);
    }

    protected static function get_device_name(Get $get, Set $set): void
    {
        if (!is_null($get('device_type_id')) && !is_null($get('customer_id'))) {
            //obtener el símbol del dispositivo y poner solo en mayúsculas y filtrar tipo slug
            $deviceDesc = strtoupper(DeviceType::find($get('device_type_id'))->symbol);

            // Obtener el número de dispositivos del usuario y rellenar con ceros
            $userDeviceCount = str_pad(Customer::find($get('customer_id'))->count(), 4, '0', STR_PAD_LEFT);

            // Obtener el total de dispositivos en el modelo y rellenar con ceros
            $totalDeviceCount =  str_pad(Device::all()->count(), 4, '0', STR_PAD_LEFT);

            //obtener el nombre del dispositivo
            $deviceName = "$deviceDesc-$userDeviceCount-$totalDeviceCount";

            $set('name', $deviceName);
            $set('slug', Str::slug($deviceName));
        }
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
                ->label('Nombre')
                ->required()
                ->maxLength(255),
            FileUpload::make('image_url')
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
    protected static function graphics_form(Form $form): Form
    {
        return $form->schema(self::graphics_schema());
    }

    protected static function graphics_schema(): array
    {
        return [
            Wizard::make()
                ->columnSpanFull()
                ->skippable()
                ->schema([
                    Step::make('Nombre')
                        ->columns(2)
                        ->schema([
                            TextInput::make('name')
                                ->required()
                                ->disabled(fn (Get $get) => $get('auto_name') ? true : false)
                                ->dehydrated(),
                            TextInput::make('slug')
                                ->required()
                                ->disabled()
                                ->dehydrated(),
                            Select::make('graphic_manufacturer_id')
                                ->relationship('graphicManufacturer', 'name')
                                ->required(fn (Get $get) => $get('auto_name') ? true : false)
                                ->label('Fabricante')
                                ->live()
                                ->afterStateUpdated(fn (Get $get, Set $set) => self::get_graphic_name($get, $set))
                                ->preload()
                                ->createOptionForm(self::graphic_manufacturer_schema())
                                ->searchable(),
                            Select::make('graphic_serie_id')
                                ->label('Sufijo')
                                ->relationship(
                                    name: 'graphicSerie',
                                    modifyQueryUsing: fn (Builder $query, Get $get) => $query->where('graphic_manufacturer_id', $get('graphic_manufacturer_id'))
                                )
                                ->getOptionLabelFromRecordUsing(fn (GraphicSerie $record) => "$record->name - [Prefijo: $record->prefix]")
                                ->createOptionForm(self::graphic_serie_schema())
                                ->label('Serie')
                                ->live()
                                ->required(fn (Get $get) => $get('auto_name') ? true : false)
                                ->afterStateUpdated(fn (Get $get, Set $set) => self::get_graphic_name($get, $set))
                                ->preload()
                                ->searchable(),
                            TextInput::make('model')
                                ->label('Modelo')
                                ->live()
                                ->required(fn (Get $get) => $get('auto_name') ? true : false)
                                ->afterStateUpdated(fn (Get $get, Set $set) => self::get_graphic_name($get, $set))
                                ->maxLength(255),
                            Select::make('graphic_sufix_id')
                                ->label('Sufijo')
                                ->required(fn (Get $get) => $get('auto_name') ? true : false)
                                ->relationship(
                                    name: 'graphicSufix',
                                    titleAttribute: 'name',
                                    modifyQueryUsing: fn (Builder $query, Get $get) => $query->where('graphic_manufacturer_id', $get('graphic_manufacturer_id'))
                                )
                                ->getOptionLabelFromRecordUsing(fn (GraphicSufix $record) => "$record->name - [$record->description]")
                                ->searchable()
                                ->live()
                                ->afterStateUpdated(fn (Get $get, Set $set) => self::get_graphic_name($get, $set))
                                ->createOptionForm(self::graphic_sufix_schema())
                                ->preload()
                                ->multiple()
                                ->native(false),
                            ToggleButtons::make('auto_name')
                                ->label('Generar Automáticamente el nombre?')
                                ->columnSpanFull()
                                ->helperText('Para Tarjetas gráficas modernas, el algoritmo generará automáticamente los nombres, pero si son antiguos o están fuera de las nomenclaturas, desactiva esta opción para indicarlo manualmente')
                                ->inline()
                                ->live()
                                ->default(true)
                                ->boolean(),
                        ]),
                    Step::make('Datos Adicionales')
                        ->columns(2)
                        ->schema([
                            TextInput::make('clock')
                                ->label('Velocidad de Reloj')
                                ->maxLength(255),
                            TextInput::make('memory_capacity')
                                ->label('Capacidad de la memoria')
                                ->maxLength(255),
                            TextInput::make('specifications_url')
                                ->label('Link de especificaciones')
                                ->prefixIcon('')
                                ->maxLength(255),
                            Select::make('memory_type_id')
                                ->label('Tipo de memoria')
                                ->relationship('memoryType', 'description')
                                ->createOptionForm(self::memory_type_schema())
                                ->searchable()
                                ->preload(),
                            FileUpload::make('image_url')
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

    protected static function get_graphic_name(Get $get, Set $set): void
    {
        if ($get('auto_name')) {
            if (!is_null($get('graphic_manufacturer_id'))  && !is_null($get('graphic_serie_id')) && !is_null($get('model')) && !is_null($get('graphic_sufix_id'))) {
                $manufacturer = ucfirst(GraphicManufacturer::find($get('graphic_manufacturer_id'))->name);
                $serie = GraphicSerie::find($get('graphic_serie_id'))->prefix;
                $model = $get('model');
                $sufixIds = $get('graphic_sufix_id');

                //Obtener sufijos y prioridades
                $sufixes = [];
                foreach ($sufixIds as $id) {
                    $sufix = GraphicSufix::find($id);
                    if ($sufix) {
                        $sufixes[$sufix->id] = [
                            'name' => $sufix->name,
                            'priority' => $sufix->priority
                        ];
                    }
                }

                // Ordenar sufijos por prioridad
                $orderedSufixes = [];
                foreach ($sufixes as $priority => $sufixData) {
                    $orderedSufixes[$priority][] = $sufixData['name'];
                }
                ksort($orderedSufixes);

                // Concatenar sufijos en un string
                $finalString = '';
                foreach ($orderedSufixes as $priority => $sufixNames) {
                    $sufixString = implode(', ', $sufixNames);
                    $finalString .= "$sufixString ";
                }
                $finalString = trim($finalString);

                $name = "$manufacturer $serie" . "$model " . $finalString;
                $set('name', $name);
                $set('slug', Str::slug($name));
            }
        } else {
            if (!is_null($get('name'))) {
                $set('slug', Str::slug($get('name')));
            }
        }
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
            TextInput::make('name')
                ->label('Nombre')
                ->required()
                ->maxLength(255),
            Select::make('brand_id')
                ->relationship('brand', 'name')
                ->createOptionForm(self::brand_schema())
                ->searchable()
                ->label('Marca')
                ->preload()
                ->required(),
            Select::make('peripheral_type_id')
                ->label('Tipo de Periférico')
                ->relationship('peripheralType', 'name')
                ->createOptionForm(self::peripheral_type_schema())
                ->searchable()
                ->native(false)
                ->preload()
                ->required(),
            FileUpload::make('image_url')
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
    protected static function peripheral_type_form(Form $form): Form
    {
        return $form->schema(self::peripheral_type_schema());
    }

    protected static function peripheral_type_schema(): array
    {
        return [
            TextInput::make('name')
                ->unique(ignoreRecord: true)
                ->label('Nombre')
                ->live(onBlur: true)
                ->afterStateUpdated(fn (HasForms $livewire, TextInput $componente) => self::validate_one_field($livewire, $componente))
                ->columnSpanFull()
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
                                ->live(onBlur: true)
                                ->afterStateUpdated(fn (Get $get, Set $set) => self::get_ram_name($get, $set))
                                ->createOptionForm(self::brand_schema())
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

    protected static function proccessor_form(Form $form): Form
    {
        return $form->schema(self::proccessor_schema());
    }

    protected static function proccessor_schema(): array
    {
        return [
            Wizard::make()
                ->columnSpanFull()
                ->skippable()
                ->schema([
                    Step::make('Nombre')
                        ->columns(2)
                        ->schema([
                            TextInput::make('name')
                                ->label('Nombre')
                                ->required()
                                ->disabled(fn (Get $get) => $get('auto_name') ? true : false)
                                ->live(onBlur: true)
                                ->afterStateUpdated(fn (Get $get, Set $set) => self::get_processor_name($get, $set))
                                ->dehydrated()
                                ->helperText('El nombre y el slug se generan en base al modelo, generación, serie, sufijo, y fabricante')
                                ->maxLength(255),
                            TextInput::make('slug')
                                ->disabled()
                                ->dehydrated()
                                ->required()
                                ->maxLength(255),
                            Select::make('processor_manufacturer_id')
                                ->label('Fabricante')
                                ->required(fn (Get $get) => $get('auto_name') ? true : false)
                                ->native(false)
                                ->searchable()
                                ->createOptionForm(self::processor_manufacturer_schema())
                                ->relationship('processorManufacturer', 'name')
                                ->helperText('Al seleccionar un fabricante apareceran las series y sufijos correspondientes')
                                ->live(onBlur: true)
                                ->afterStateUpdated(fn (Get $get, Set $set) => self::get_processor_name($get, $set))
                                ->preload(),
                            Select::make('processor_serie_id')
                                ->label('Serie')
                                ->required(fn (Get $get) => $get('auto_name') ? true : false)
                                ->searchable()
                                ->relationship(
                                    name: 'processorSerie',
                                    titleAttribute: 'name',
                                    modifyQueryUsing: fn (Builder $query, Get $get) => $query->where('processor_manufacturer_id', $get('processor_manufacturer_id'))->orderBy('name')
                                )
                                ->live(onBlur: true)
                                ->createOptionForm(self::processor_serie_schema())
                                ->afterStateUpdated(fn (Get $get, Set $set) => self::get_processor_name($get, $set))
                                ->preload(),
                            Select::make('processor_generation_id')
                                ->label('Generación')
                                ->relationship(
                                    name: 'processorGeneration',
                                    titleAttribute: 'name',
                                    modifyQueryUsing: fn (Builder $query, Get $get) => $query->where('processor_manufacturer_id', $get('processor_manufacturer_id'))
                                )
                                ->live(onBlur: true)
                                ->createOptionForm(self::processor_generation_schema())
                                ->afterStateUpdated(fn (Get $get, Set $set) => self::get_processor_name($get, $set))
                                ->native(false)
                                ->required(fn (Get $get) => $get('auto_name') ? true : false)
                                ->searchable()
                                ->preload(),
                            TextInput::make('model')
                                ->label('Modelo')
                                ->required(fn (Get $get) => $get('auto_name') ? true : false)
                                ->afterStateUpdated(fn (Get $get, Set $set) => self::get_processor_name($get, $set))
                                ->live(onBlur: true)
                                ->helperText('Es el número luego de la generación')
                                ->maxLength(255),
                            Select::make('processor_sufix_id')
                                ->label('Sufijo')
                                ->relationship(
                                    name: 'processorSufix',
                                    titleAttribute: 'name',
                                    modifyQueryUsing: fn (Builder $query, Get $get) => $query->where('processor_manufacturer_id', $get('processor_manufacturer_id'))
                                )
                                ->searchable()
                                ->getOptionLabelFromRecordUsing(fn (ProcessorSufix $record) => "$record->name - [" . self::get_sufix_description($record->description) . "]")
                                ->createOptionForm(self::processor_sufix_schema())
                                ->preload()
                                ->live(onBlur: true)
                                ->afterStateUpdated(fn (Get $get, Set $set) => self::get_processor_name($get, $set)),
                            ToggleButtons::make('auto_name')
                                ->label('Generar Automáticamente el nombre?')
                                ->columnSpanFull()
                                ->helperText('Para procesadores modernos, el algoritmo generará automáticamente los nombres, pero si son antiguos o están fuera de las nomenclaturas modernas, desactiva esta opción para indicarlo manualmente')
                                ->inline()
                                ->live()
                                ->default(true)
                                ->boolean(),
                        ]),
                    Step::make('Información Adicional')
                        ->columns(2)
                        ->description('Los datos de esta sección son opcionales pero importantes')
                        ->schema([
                            TextInput::make('cores')
                                ->label('Nucleos')
                                ->numeric()
                                ->integer()
                                ->maxLength(255),
                            TextInput::make('threads')
                                ->label('Hilos')
                                ->numeric()
                                ->integer()
                                ->maxLength(255),
                            TextInput::make('socket')
                                ->label('Socket')
                                ->maxLength(255),
                            TextInput::make('tdp')
                                ->label('T.D.P.')
                                ->maxLength(255),
                            TextInput::make('integrated_graphics')
                                ->label('Gráficos Integrados')
                                ->maxLength(255),
                            Select::make('memory_type_id')
                                ->label('Tipo de memoria Ram')
                                ->relationship('memoryType', 'description')
                                ->createOptionForm(self::memory_type_schema())
                                ->searchable()
                                ->preload(),
                            TextInput::make('memory_capacity')
                                ->label('Total de memoria Ram')
                                ->maxLength(255),
                            Select::make('processor_condition_id')
                                ->label('Condición del procesador')
                                ->relationship('processorCondition', 'description')
                                ->createOptionForm(self::processor_condition_schema())
                                ->searchable()
                                ->preload(),
                            TextInput::make('specifications_url')
                                ->label('Link de especificaciones')
                                ->helperText('Si tienes el link de las especificaciones del procesador, las puedes guardar aquí para acceder más rápidamente.')
                                ->suffixIcon('heroicon-m-globe-alt')
                                ->columnSpanFull()
                                ->url(),
                            FileUpload::make('image_url')
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

    protected static function get_processor_name(Get $get, Set $set): void
    {
        if ($get('auto_name')) {
            if (!is_null($get('processor_manufacturer_id')) && !is_null($get('model')) && !is_null($get('processor_serie_id')) && !is_null($get('processor_generation_id'))) {
                $manufacturer = (ProcessorManufacturer::find($get('processor_manufacturer_id'))->name);
                $model = $get('model');
                $serie = ProcessorSerie::find($get('processor_serie_id'))->name;
                $sufijo = $get('processor_sufix_id') ? strtoupper(ProcessorSufix::find($get('processor_sufix_id'))->name) : '';
                $generation = ProcessorGeneration::find($get('processor_generation_id'))->prefix;
                $name = "$manufacturer $serie $generation" . $model . $sufijo;
                $set('name', $name);
                $set('slug', Str::slug($name));
            }
        } else {
            if (!is_null($get('name'))) {
                $set('slug', Str::slug($get('name')));
            }
        }
    }

    protected static function get_sufix_description($description): string
    {
        return $description ? $description : 'No hay descripción disponible';
    }
}
