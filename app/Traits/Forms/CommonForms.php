<?php

namespace App\Traits\Forms;

use App\Models;
use Filament\Forms;
use Awcodes\TableRepeater\Components\TableRepeater;
use Awcodes\TableRepeater\Header;
use Carbon\Carbon;
use FilamentTiptapEditor\TiptapEditor;
use Illuminate\Support\Str;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Rawilk\FilamentPasswordInput\Password;
use Cheesegrits\FilamentGoogleMaps\Fields\Geocomplete;
use Cheesegrits\FilamentGoogleMaps\Fields\Map;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Set;
use Ysfkaya\FilamentPhoneInput\Forms\PhoneInput;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Facades\Blade;
use Rawilk\FilamentPasswordInput\Actions\CopyToClipboardAction;

trait CommonForms
{
    use TraitForms, DevicesTraitForms;

    /**
     * DeviceForms
     */
    protected static function device_form(Forms\Form $form): Forms\Form
    {
        return $form->schema(self::device_schema());
    }

    protected static function device_schema(int $customerId = null): array
    {
        return [
            Forms\Components\wizard::make()
                ->schema([
                    Forms\Components\wizard\Step::make('Información Básica')
                        ->schema([
                            Forms\Components\TextInput::make('name')
                                ->disabled()
                                ->dehydrated()
                                ->helperText('El nombre y el slug se crearán automáticamente despues de seleccionar un tipo de dispositivo y el dueño'),
                            Forms\Components\TextInput::make('slug')
                                ->disabled()
                                ->dehydrated(),
                            Forms\Components\Select::make('motherboard_id')
                                ->label('Placa Madre')
                                ->relationship('motherboard', 'name')
                                ->searchable()
                                ->preload()
                                ->createOptionForm(self::motherboard_schema())
                                ->editOptionForm(self::motherboard_schema())
                                ->columnSpanFull(),
                            Forms\Components\Select::make('device_type_id')
                                ->relationship('deviceType', 'description')
                                ->native(false)
                                ->label('Tipo de dispositivo')
                                ->live(onBlur: true)
                                ->afterStateUpdated(fn(Forms\Get $get, Forms\Set $set) => self::get_device_name($get, $set))
                                ->searchable()
                                ->preload()
                                ->required(),
                            Forms\Components\Select::make('customer_id')
                                ->relationship('customers', 'name')
                                ->createOptionForm(fn() => self::customer_schema())
                                ->editOptionForm(fn() => self::customer_schema())
                                ->disabled(fn() => $customerId ? true : false)
                                ->dehydrated()
                                ->default($customerId)
                                ->native(false)
                                ->label('Dueño')
                                ->live(onBlur: true)
                                ->afterStateUpdated(fn(Forms\Get $get, Forms\Set $set) => self::get_device_name($get, $set))
                                ->preload()
                                ->searchable()
                                ->required(),
                            Forms\Components\Select::make('processor_id')
                                ->relationship('processor', 'name')
                                ->label('Procesador')
                                ->native(false)
                                ->createOptionForm(self::proccessor_schema())
                                ->editOptionForm(self::proccessor_schema())
                                ->searchable()
                                ->preload(),
                            Forms\Components\TextInput::make('identifier')
                                ->label('Identificador')
                                ->helperText('Puedes Escribir lo que gustes aquí para poder identificar este dispositivo en otros recursos (ej. Pc de Hijo mayor)'),
                            Forms\Components\TextInput::make('ram_total')
                                ->label('Ram total')
                                ->helperText('Se rellena automáticamente dependiendo las memorias registradas en la siguiente sección')
                                ->disabled()
                                ->dehydrated()
                                ->integer()
                                ->numeric(),
                            Forms\Components\Select::make('device_state_id')
                                ->label('Estado del dispositivo')
                                ->relationship('deviceState', 'name')
                                ->createOptionForm(self::device_state_schema())
                                ->native(false)
                                ->searchable()
                                ->preload(),
                            Forms\Components\FileUpload::make('speccy_snapshot_url')
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
                    Forms\Components\wizard\Step::make('Componenentes')
                        ->schema([
                            Forms\Components\Tabs::make()
                                ->tabs([
                                    Forms\Components\Tabs\Tab::make('Sistemas operativos')
                                        ->schema([
                                            TableRepeater::make('deviceOperatingSystems')
                                                ->relationship()
                                                ->emptyLabel('Aún no hay sistemas operativos registrados')
                                                ->label('Sistemas Operativos')
                                                ->headers([
                                                    Header::make('Sistema Operativo')
                                                ])
                                                ->schema([
                                                    Forms\Components\Select::make('operating_system_id')
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
                                    Forms\Components\Tabs\Tab::make('Almacenamiento')
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
                                                    Forms\Components\Select::make('storage_id')
                                                        ->relationship('storage', 'name')
                                                        ->native(false)
                                                        ->createOptionForm(self::storage_schema())
                                                        ->preload()
                                                        ->required()
                                                        ->searchable(),
                                                    Forms\Components\TextInput::make('quantity')
                                                        ->minValue(1)
                                                        ->numeric()
                                                        ->integer()
                                                        ->default(1)
                                                ])
                                                ->defaultItems(0)
                                                ->columnSpanFull(),
                                        ]),
                                    Forms\Components\Tabs\Tab::make('Tarjetas Gráficas')
                                        ->schema([
                                            TableRepeater::make('deviceGraphics')
                                                ->label('Tarjetas Gráficas')
                                                ->emptyLabel('Aún no hay tarjetas gráficas registrados')
                                                ->relationship()
                                                ->headers([
                                                    Header::make('Nombre')
                                                ])
                                                ->schema([
                                                    Forms\Components\Select::make('graphic_id')
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
                                    Forms\Components\Tabs\Tab::make('Periféricos')
                                        ->schema([
                                            TableRepeater::make('devicePeripherals')
                                                ->label('Periféricos')
                                                ->relationship()
                                                ->emptyLabel('Aún no hay periféricos registrados')
                                                ->headers([
                                                    Header::make('Periférico')
                                                ])
                                                ->schema([
                                                    Forms\Components\Select::make('peripheral_id')
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
                                    Forms\Components\Tabs\Tab::make('Ram')
                                        ->live()
                                        ->schema([
                                            TableRepeater::make('deviceRams')
                                                ->label('Ram')
                                                ->relationship()
                                                ->afterStateUpdated(fn(Forms\Get $get, Forms\Set $set) => self::get_total_ram($get, $set))
                                                ->deleteAction(
                                                    fn(Forms\Components\Actions\Action $action) => $action->after(fn(Forms\Get $get, Forms\Set $set) => self::get_total_ram($get, $set)),
                                                )
                                                ->emptyLabel('Aún no hay memorias ram registradas')
                                                ->headers([
                                                    Header::make('Ram'),
                                                    Header::make('Cantidad')
                                                ])
                                                ->schema([
                                                    Forms\Components\Select::make('ram_id')
                                                        ->relationship('ram', 'name')
                                                        ->createOptionForm(self::ram_schema())
                                                        ->preload()
                                                        ->required()
                                                        ->searchable(),
                                                    Forms\Components\TextInput::make('quantity')
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
                    Forms\Components\wizard\Step::make('Información Adicional')
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


    /**
     * UserForms
     */

    public static function user_form(): array
    {
        return [
            Forms\Components\wizard::make([
                Forms\Components\wizard\Step::make('Información Personal')
                    ->schema(self::get_personal_info_form())
                    ->icon('heroicon-o-user')
                    ->columns(2),
                // ->description(fn () => self::get_info_desc()),
                Forms\Components\wizard\Step::make('Información de Cuenta')
                    ->schema(self::get_account_info_form())
                    ->icon('heroicon-m-book-open')
                    ->columns(2),
                Forms\Components\wizard\Step::make('Rol')
                    ->icon('heroicon-s-building-office')
                    ->schema([
                        Forms\Components\Select::make('roles')
                            ->multiple()
                            ->preload()
                            ->relationship('roles', 'name'),
                    ])
                    ->visible(getUserAuth()->hasRole('super_admin')),
                Forms\Components\wizard\Step::make('Información adicional')
                    ->schema(self::get_aditional_info())
            ])
                ->columnSpanFull()
                ->skippable(),
        ];
    }

    // public static function get_personal_info_form(): array
    // {
    //     return [
    //         Forms\Components\TextInput::make('document_number')
    //             ->label('Número de Documento')
    //             ->live(onBlur: true)
    //             ->unique(ignoreRecord: true)
    //             ->afterStateUpdated(function (Forms\Get $get, Forms\Set $set, Forms\Contracts\HasForms $livewire, Forms\Components\TextInput $component) {
    //                 self::validate_one_field($livewire, $component);
    //                 self::set_data_from_api($get, $set);
    //             })
    //             ->helperText(fn() => self::getHelperText())
    //             ->required()
    //             ->maxLength(255),
    //         Forms\Components\Select::make('id_document_id')
    //             ->label('Tipo de documento')
    //             ->relationship('idDocument', 'description')
    //             ->afterStateUpdated(fn(Forms\Get $get, Forms\Set $set) => self::set_data_from_api($get, $set))
    //             ->default(2)
    //             ->searchable()
    //             ->preload()
    //             ->live(),
    //         Forms\Components\TextInput::make('name')
    //             ->label('Nombre/Razón Social')
    //             ->required()
    //             ->maxLength(255),
    //         Forms\Components\TextInput::make('last_name_m')
    //             ->label('Apellido Materno')
    //             ->hidden(fn(Forms\Get $get) => $get('id_document_id') == 4)
    //             ->maxLength(255),
    //         Forms\Components\TextInput::make('last_name_p')
    //             ->label('Apellido Paterno')
    //             ->hidden(fn(Forms\Get $get) => $get('id_document_id') == 4)
    //             ->maxLength(255),
    //         Forms\Components\FileUpload::make('avatar_url')
    //             ->label('Foto de Perfil')
    //             ->avatar()
    //             ->imageEditor()
    //             ->directory('avatars')
    //             ->optimize('webp')
    //             ->resize(50),
    //     ];
    // }

    // public static function get_account_info_form(): array
    // {
    //     return [
    //         Forms\Components\TextInput::make('email')
    //             ->email()
    //             ->afterStateUpdated(fn(Forms\Contracts\HasForms $livewire, Forms\Components\TextInput $component) => self::validate_one_field($livewire, $component))
    //             ->unique(ignoreRecord: true)
    //             ->required()
    //             ->disabledOn('edit')
    //             ->maxLength(255),
    //         Password::make('password')
    //             ->password()
    //             ->regeneratePassword(color: 'danger')
    //             ->copyable(color: 'success')
    //             ->revealable()
    //             ->hiddenOn([
    //                 'edit',
    //                 'view'
    //             ])
    //             ->required()
    //             ->maxLength(12),
    //     ];
    // }

    // protected static function get_aditional_info(): array
    // {
    //     return [
    //         TableRepeater::make('phones')
    //             ->label('Teléfonos')
    //             ->headers([
    //                 Header::make('Número')
    //                     ->markAsRequired(),
    //                 Header::make('Descripción'),
    //                 Header::make('whatsapp'),
    //                 Header::make('Enlace')
    //             ])
    //             ->emptyLabel('Aún no hay números telefónicos asociados')
    //             ->relationship()
    //             ->defaultItems(0)
    //             ->schema([
    //                 PhoneInput::make('number')
    //                     ->label('Número')
    //                     ->required()
    //                     ->live(onBlur: true)
    //                     ->afterStateUpdated(fn(Forms\Get $get, Forms\Set $set) => self::getWspLink($get, $set)),
    //                 Forms\Components\TextInput::make('description')
    //                     ->label('Descripción')
    //                     ->columnSpanFull(),
    //                 Forms\Components\Toggle::make('wsp')
    //                     ->live(onBlur: true)
    //                     ->afterStateUpdated(fn(Forms\Get $get, Forms\Set $set) => self::getWspLink($get, $set)),
    //                 Forms\Components\TextInput::make('wsp_link')
    //                     ->disabled()
    //                     ->dehydrated()
    //                     ->live(onBlur: true)
    //                     ->url()
    //                     ->suffixAction(
    //                         Forms\Components\Actions\Action::make('openLink')
    //                             ->icon('heroicon-o-chat-bubble-bottom-center-text')
    //                             ->url(fn($state) => $state)
    //                             ->extraAttributes([
    //                                 'target' => '_blank',
    //                                 'title' => 'Chatea con tu cliente'
    //                             ])
    //                             ->disabled(fn($state) => $state ? false : true)
    //                     )
    //             ]),
    //         TableRepeater::make('emails')
    //             ->label('Correos Electrónicos')
    //             ->emptyLabel('Aún no hay correos electrónicos asociados')
    //             ->headers([
    //                 Header::make('Correo Electrónico')
    //             ])
    //             ->relationship()
    //             ->defaultItems(0)
    //             ->schema([
    //                 Forms\Components\TextInput::make('email')
    //                     ->label('Correo')
    //                     ->email()
    //                     ->required()
    //                     ->suffixIcon('heroicon-c-at-symbol')
    //                     ->maxLength(255),
    //             ])
    //     ];
    // }

    public static function get_info_desc(): string
    {
        return getApiStatus(Models\Api::find(1)) ? 'La información se llenará automáticamente en base al tipo de documento seleccionados [DNI, RUC]' : '';
    }

    /**
     * Customer
     */
    protected static function customer_form(Forms\Form $form): Forms\Form
    {
        return $form->schema(self::customer_schema());
    }

    protected static function customer_schema(): array
    {
        return [
            Forms\Components\wizard::make([
                Forms\Components\wizard\Step::make('Información Básica')
                    ->schema(self::get_costumer_personal_info_form())
                    ->columns(2),
                Forms\Components\wizard\Step::make('Información de la cuenta')
                    ->schema([
                        Forms\Components\Repeater::make('user')
                            ->relationship()
                            ->schema(
                                self::get_costumber_account_info_form(),
                            )
                            ->addable(false)
                            ->deletable(false)
                            ->defaultItems(1)
                            ->columns(2)
                    ]),
                // Forms\Components\wizard\Step::make('Direcciones')
                //     ->schema(self::location_form()),
                Forms\Components\wizard\Step::make("Teléfonos & Email's")
                    ->schema(self::get_aditional_info()),
            ])->columnSpanFull()
                ->skippable(),
        ];
    }

    //customer forms
    public static function get_costumer_personal_info_form(): array
    {
        return [
            Forms\Components\TextInput::make('document_number')
                ->label('Número de Documento')
                ->unique(ignoreRecord: true)
                ->live(onBlur: true)
                ->afterStateUpdated(function (Forms\Get $get, Forms\Set $set, Forms\Contracts\HasForms $livewire, Forms\Components\TextInput $component) {
                    self::set_data_from_api($get, $set);
                    self::validate_one_field($livewire, $component);
                })
                ->helperText(fn() => self::getHelperText())
                ->prefixAction(Action::make('clean')
                    ->icon('heroicon-o-x-mark')
                    ->color('gray')
                    ->label('Limpiar')
                    ->action(function (Set $set) {
                        $set('document_number', '');
                    }),)
                ->suffixAction(
                    CopyToClipboardAction::make('copy')
                )
                ->hint(new HtmlString(Blade::render('<x-filament::loading-indicator class="h-5 w-5" wire:loading wire:target="data.document_number" />')))
                ->required()
                ->maxLength(255),
            Forms\Components\Select::make('id_document_id')
                ->label('Tipo de documento')
                ->relationship('idDocument', 'description')
                ->afterStateUpdated(fn(Forms\Get $get, Forms\Set $set) => self::set_data_from_api($get, $set))
                ->hint(new HtmlString(Blade::render('<x-filament::loading-indicator class="h-5 w-5" wire:loading wire:target="data.id_document_id" />')))
                ->searchable()
                ->preload()
                ->default(2)
                ->live(),
            Forms\Components\TextInput::make('name')
                ->label('Nombre/Razón Social')
                ->live()
                ->hint(new HtmlString(Blade::render('<x-filament::loading-indicator class="h-5 w-5" wire:loading wire:target="data.name" />')))
                ->required()
                ->maxLength(255),
            Forms\Components\TextInput::make('last_name_m')
                ->label('Apellido Materno')
                ->hidden(fn(Forms\Get $get) => $get('id_document_id') == 4)
                ->maxLength(255),
            Forms\Components\TextInput::make('last_name_p')
                ->label('Apellido Paterno')
                ->hidden(fn(Forms\Get $get) => $get('id_document_id') == 4)
                ->maxLength(255),
            Forms\Components\Section::make('Dispositivos')
                ->description('Registra y asocia los dispositivos al usuario, solo se podrá hacer al editar el usuario, no mientras estás creando')
                ->schema([
                    TableRepeater::make('customerDevice')
                        ->headers([
                            Header::make('Dispositivo')
                        ])
                        ->hiddenLabel()
                        ->disabledOn('create')
                        ->emptyLabel('Aún no hay Dispositivos asociados')
                        ->label('Dispositivos')
                        ->relationship()
                        ->schema([
                            Forms\Components\Select::make('device_id')
                                ->relationship(name: 'device', titleAttribute: 'name')
                                ->label('Seleccionar Dispositivo o crea uno nuevo')
                                ->createOptionForm(fn($livewire) => self::device_schema($livewire->getRecord()->id))
                                ->editOptionForm(fn() => self::device_schema())
                                ->searchable()
                                ->preload()
                                ->required(),
                        ])
                        ->collapsible()
                        ->defaultItems(0)
                        ->minItems(0)
                ])
        ];
    }

    public static function get_costumber_account_info_form(): array
    {
        return [
            Forms\Components\TextInput::make('email')
                ->email()
                ->unique(ignoreRecord: true)
                // ->required()
                ->live(onBlur: true)
                ->afterStateUpdated(fn(Forms\Contracts\HasForms $livewire, Forms\Components\TextInput $component) => self::validate_one_field($livewire, $component))
                // ->disabledOn('edit')
                ->maxLength(255),
            Password::make('password')
                ->password()
                ->regeneratePassword(color: 'danger')
                ->copyable(color: 'success')
                ->revealable()
                ->hiddenOn([
                    // 'edit',
                    'view'
                ])
                // ->required()
                ->maxLength(12),
            Forms\Components\FileUpload::make('avatar_url')
                ->label('Foto de Perfil')
                ->avatar()
                ->imageEditor()
                ->directory('avatars')
                ->optimize('webp')
                ->resize(50),
        ];
    }

    public static function location_form(): array
    {
        if (getApiStatus(Models\Api::find(2))) {
            $location_input = Geocomplete::make('address')
                ->isLocation()
                ->reverseGeocode([
                    'city'   => '%L',
                    'zip'    => '%z',
                    'state'  => '%A1',
                    'street' => '%n %S',
                ])
                ->countries(['pe']) // restrict autocomplete results to these countries
                ->debug() // output the results of reverse geocoding in the browser console, useful for figuring out symbol formats
                ->updateLatLng() // update the lat/lng fields on your Forms\Form when a Place is Forms\Components\Selected
                ->maxLength(1024)
                ->live()
                ->prefix('Escoge:')
                ->placeholder('Escribe una dirección ...')
                ->geolocate() // add a suffix button which requests and reverse geocodes the device location
                ->geolocateIcon('heroicon-o-map'); // override the default icon for the geolocate button;
            $headers = [
                Header::make('Descripción'),
                Header::make('Referencia'),
                Header::make('Latitud'),
                Header::make('Longitud'),
                Header::make('Dirección'),
                Header::make('Ubicación'),
            ];
        } elseif (!getApiStatus(Models\Api::find(2))) {
            $location_input = Forms\Components\TextInput::make('address')
                ->label('Direccion');
            $headers = [
                Header::make('Descripción'),
                Header::make('Referencia'),
                // Header::make('Latitud'),
                // Header::make('Longitud'),
                // Header::make('Dirección'),
                Header::make('Ubicación')
                    ->markAsRequired(),
            ];
        }

        return [
            TableRepeater::make('locations')
                ->relationship()
                ->headers($headers)
                ->defaultItems(0)
                ->emptyLabel('Aún no hay direcciones registradas')
                ->schema([
                    Forms\Components\TextInput::make('description')
                        ->label('Descripción')
                        ->live(onBlur: true),
                    Forms\Components\TextInput::make('reference')
                        ->label('Referencia'),
                    Forms\Components\TextInput::make('lat')
                        ->label('Latitud')
                        ->reactive()
                        ->hidden(!getApiStatus(Models\Api::find(2)))
                        ->afterStateUpdated(function ($state, callable $get, callable $set) {
                            $set('location', [
                                'lat' => floatVal($state),
                                'lng' => floatVal($get('lng')),
                            ]);
                        })
                        ->lazy(),
                    Forms\Components\TextInput::make('lng')
                        ->label('Longitud')
                        ->reactive()
                        ->hidden(!getApiStatus(Models\Api::find(2)))
                        ->afterStateUpdated(function ($state, callable $get, callable $set) {
                            $set('location', [
                                'lat' => floatval($get('lat')),
                                'lng' => floatVal($state),
                            ]);
                        })
                        ->lazy(),
                    $location_input,
                    Map::make('location')
                        ->label('Ubicación')
                        ->columnSpanFull()
                        ->autocomplete('address')
                        ->autocompleteReverse(true) // reverse geocode marker location to autocomplete field
                        ->hidden(!getApiStatus(Models\Api::find(2)))
                        ->reactive()
                        ->defaultZoom(19)
                        ->mapControls([
                            'zoomControl' => true,
                        ])
                        ->debug()
                        ->drawingControl()
                        ->defaultLocation([-12.0577422, -77.0738183])
                        ->geolocate() // adds a button to request device location and Forms\Set map marker accordingly
                        ->geolocateLabel('Forms\Get Location') // overrides the default label for geolocate button
                        ->geolocateOnLoad(true, false) // geolocate on load, second arg 'always' (default false, only for new form))
                        ->afterStateUpdated(function ($state, callable $get, callable $set) {
                            $set('lat', $state['lat']);
                            $set('lng', $state['lng']);
                        }),
                ])
                ->label('Direcciones')
                ->live()
                ->reactive()
                ->lazy()
                ->columns(2)
                ->itemLabel(fn(array $state): ?string => Str::upper($state['description']) ?? null)
        ];
    }

    protected static function get_devices_form(): array
    {
        return [
            Forms\Components\Select::make('devices')
                ->relationship(name: 'devices', titleAttribute: 'name')
                ->multiple()
                ->preload()
                ->searchable()
                ->native(false)
        ];
    }

    protected static function getWspLink(Forms\Get $get, Forms\Set $set): void
    {
        if ($get('wsp')) {
            $phone_number = $get('number');
            if ($phone_number) {
                $link = "https://wa.me/{$phone_number}";
                $set('wsp_link', $link);
            } else {
                $set('wsp_link', '');
            }
        } else {
            $set('wsp_link', '');
        }
    }


    //common methods
    public static function getHelperText()
    {
        return getApiStatus(Models\Api::find(1)) ? 'Ingrese el número de su documento y se llenará automaticamente si el tipo de documento es RUC ó DNI' : '';
    }

    /**
     * Coloca los valores recibidos por la api APISNET.NET en los campos respectivos
     * dependiendo si se encuentra activado el uso de esta api
     */
    public static function set_data_from_api(Forms\Get $get, Forms\Set $set): void
    {
        $document_type = $get('id_document_id');
        $document_number = $get('document_number');

        if (getApiStatus(Models\Api::find(1)) == true) {
            if ($document_type != null && $document_number != null) {
                if ($document_type == 2) {
                    $data = getDataFromDni($document_number);
                    $set('name', capitalizeEachWord($data->nombres));
                    $set('last_name_m', capitalizeEachWord($data->apellidoMaterno));
                    $set('last_name_p', capitalizeEachWord($data->apellidoPaterno));
                } elseif ($document_type == 4) {
                    $data = getDataFromRuc($document_number);
                    $set('name', $data->razonSocial);
                }
            } elseif ($document_type == null || $document_number == null) {
                $document_number == null && $set('id_document_id', null);
                $set('name', null);
                $set('last_name_m', null);
                $set('last_name_p', null);
            }
        }
    }

    protected static function get_device_name(Forms\Get $get, Forms\Set $set): void
    {
        if (!is_null($get('device_type_id')) && !is_null($get('customer_id'))) {
            //obtener el símbol del dispositivo y poner solo en mayúsculas y filtrar tipo slug
            $deviceDesc = strtoupper(Models\DeviceType::find($get('device_type_id'))->symbol);

            // Obtener el número de dispositivos del usuario y rellenar con ceros
            $userDeviceCount = str_pad(Models\Customer::find($get('customer_id'))->count(), 4, '0', STR_PAD_LEFT);

            // Obtener el total de dispositivos en el modelo y rellenar con ceros
            $totalDeviceCount =  str_pad(Models\Device::all()->count(), 4, '0', STR_PAD_LEFT);

            //obtener el nombre del dispositivo
            $deviceName = "$deviceDesc-$userDeviceCount-$totalDeviceCount";

            $set('name', $deviceName);
            $set('slug', Str::slug($deviceName));
        }
    }
}
