<?php

namespace App\Traits\Forms;

use App\Models\Api;
use App\Models\Customer;
use App\Models\User;
use Cheesegrits\FilamentGoogleMaps\Fields\Geocomplete;
use Cheesegrits\FilamentGoogleMaps\Fields\Map;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Awcodes\TableRepeater\Components\TableRepeater;
use Awcodes\TableRepeater\Header;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Rawilk\FilamentPasswordInput\Password;
use Illuminate\Support\Str;
use Ysfkaya\FilamentPhoneInput\Forms\PhoneInput;

trait UserForms
{
    use TraitForms;

    //user forms
    public static function user_form(): array
    {
        return [
            Wizard::make([
                Step::make('Información Personal')
                    ->schema(self::get_personal_info_form())
                    ->icon('heroicon-o-user')
                    ->columns(2),
                // ->description(fn () => self::get_info_desc()),
                Step::make('Información de Cuenta')
                    ->schema(self::get_account_info_form())
                    ->icon('heroicon-m-book-open')
                    ->columns(2),
                Step::make('Rol')
                    ->icon('heroicon-s-building-office')
                    ->schema([
                        Select::make('roles')
                            ->multiple()
                            ->preload()
                            ->relationship('roles', 'name'),
                    ])
                    ->visible(getUserAuth()->hasRole('super_admin')),
                Step::make('Información adicional')
                    ->schema(self::get_aditional_info())
            ])
                ->columnSpanFull()
                ->skippable(),
        ];
    }

    public static function get_personal_info_form(): array
    {
        return [
            TextInput::make('document_number')
                ->label('Número de Documento')
                ->live(onBlur: true)
                ->unique(ignoreRecord: true)
                ->afterStateUpdated(function (Get $get, Set $set, HasForms $livewire, TextInput $component) {
                    self::validate_one_field($livewire, $component);
                    self::set_data_from_api($get, $set);
                })
                ->helperText(fn() => self::getHelperText())
                ->required()
                ->maxLength(255),
            Select::make('id_document_id')
                ->label('Tipo de documento')
                ->relationship('idDocument', 'description')
                ->afterStateUpdated(fn(Get $get, Set $set) => self::set_data_from_api($get, $set))
                ->default(2)
                ->searchable()
                ->preload()
                ->live(),
            TextInput::make('name')
                ->label('Nombre/Razón Social')
                ->required()
                ->maxLength(255),
            TextInput::make('last_name_m')
                ->label('Apellido Materno')
                ->hidden(fn(Get $get) => $get('id_document_id') == 4)
                ->maxLength(255),
            TextInput::make('last_name_p')
                ->label('Apellido Paterno')
                ->hidden(fn(Get $get) => $get('id_document_id') == 4)
                ->maxLength(255),
            FileUpload::make('avatar_url')
                ->label('Foto de Perfil')
                ->avatar()
                ->imageEditor()
                ->directory('avatars')
                ->optimize('webp')
                ->resize(50),
        ];
    }

    public static function get_account_info_form(): array
    {
        return [
            TextInput::make('email')
                ->email()
                ->afterStateUpdated(fn(HasForms $livewire, TextInput $component) => self::validate_one_field($livewire, $component))
                ->unique(ignoreRecord: true)
                ->required()
                ->disabledOn('edit')
                ->maxLength(255),
            Password::make('password')
                ->password()
                ->regeneratePassword(color: 'danger')
                ->copyable(color: 'success')
                ->revealable()
                ->hiddenOn([
                    'edit',
                    'view'
                ])
                ->required()
                ->maxLength(12),
        ];
    }

    public static function get_info_desc(): string
    {
        return getApiStatus(Api::find(1)) ? 'La información se llenará automáticamente en base al tipo de documento seleccionados [DNI, RUC]' : '';
    }

    //customer forms
    public static function get_costumer_personal_info_form(): array
    {
        return [
            TextInput::make('document_number')
                ->label('Número de Documento')
                ->unique(ignoreRecord: true)
                ->live(onBlur: true)
                ->afterStateUpdated(function (Get $get, Set $set, HasForms $livewire, TextInput $component) {
                    self::set_data_from_api($get, $set);
                    self::validate_one_field($livewire, $component);
                })
                ->helperText(fn() => self::getHelperText())
                ->required()
                ->maxLength(255),
            Select::make('id_document_id')
                ->label('Tipo de documento')
                ->relationship('idDocument', 'description')
                ->afterStateUpdated(fn(Get $get, Set $set) => self::set_data_from_api($get, $set))
                ->searchable()
                ->preload()
                ->live(),
            TextInput::make('name')
                ->label('Nombre/Razón Social')
                ->required()
                ->maxLength(255),
            TextInput::make('last_name_m')
                ->label('Apellido Materno')
                ->hidden(fn(Get $get) => $get('id_document_id') == 4)
                ->maxLength(255),
            TextInput::make('last_name_p')
                ->label('Apellido Paterno')
                ->hidden(fn(Get $get) => $get('id_document_id') == 4)
                ->maxLength(255),
        ];
    }

    public static function get_costumber_account_info_form(): array
    {
        return [
            TextInput::make('email')
                ->email()
                ->unique(ignoreRecord: true)
                // ->required()
                ->live(onBlur: true)
                ->afterStateUpdated(fn(HasForms $livewire, TextInput $component) => self::validate_one_field($livewire, $component))
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
            FileUpload::make('avatar_url')
                ->label('Foto de Perfil')
                ->avatar()
                ->imageEditor()
                ->directory('avatars')
                ->optimize('webp')
                ->resize(50),
        ];
    }

    public static function customer_form(Form $form): Form
    {
        return $form->schema(self::customer_schema());
    }

    public static function customer_schema(): array
    {
        return [
            Wizard::make([
                Step::make('Información del cliente')
                    ->schema(self::get_costumer_personal_info_form())
                    ->columns(2),
                Step::make('Información de la cuenta')
                    ->schema([
                        Repeater::make('user')
                            ->relationship()
                            ->schema(
                                self::get_costumber_account_info_form(),
                            )
                            ->addable(false)
                            ->deletable(false)
                            ->defaultItems(1)
                            ->columns(2)
                    ]),
                Step::make('Direcciones')
                    ->schema(self::location_form()),
                Step::make("Teléfonos & Email's")
                    ->schema(self::get_aditional_info())
            ])->columnSpanFull()
                ->skippable(),
        ];
    }

    public static function get_aditional_info(): array
    {
        return [
            TableRepeater::make('phones')
                ->label('Teléfonos')
                ->headers([
                    Header::make('Número')
                        ->markAsRequired(),
                    Header::make('Descripción'),
                    Header::make('whatsapp'),
                    Header::make('Enlace')
                ])
                ->emptyLabel('Aún no hay números telefónicos asociados')
                ->relationship()
                ->defaultItems(0)
                ->schema([
                    PhoneInput::make('number')
                        ->label('Número')
                        ->required()
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn(Get $get, Set $set) => self::getWspLink($get, $set)),
                    TextInput::make('description')
                        ->label('Descripción')
                        ->columnSpanFull(),
                    Toggle::make('wsp')
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn(Get $get, Set $set) => self::getWspLink($get, $set)),
                    TextInput::make('wsp_link')
                        ->disabled()
                        ->dehydrated()
                        ->live(onBlur: true)
                        ->url()
                        ->suffixAction(
                            Action::make('openLink')
                                ->icon('heroicon-o-chat-bubble-bottom-center-text')
                                ->url(fn($state) => $state)
                                ->extraAttributes([
                                    'target' => '_blank',
                                    'title' => 'Chatea con tu cliente'
                                ])
                                ->disabled(fn($state) => $state ? false : true)
                            // ->action(function($state){
                            //     return redirect()->away($state);
                            // })
                        )
                ]),
            TableRepeater::make('emails')
                ->label('Correos Electrónicos')
                ->emptyLabel('Aún no hay correos electrónicos asociados')
                ->headers([
                    Header::make('Correo Electrónico')
                ])
                ->relationship()
                ->defaultItems(0)
                ->schema([
                    TextInput::make('email')
                        ->label('Correo')
                        ->email()
                        ->required()
                        ->suffixIcon('heroicon-c-at-symbol')
                        ->maxLength(255),
                ])
        ];
    }

    protected static function getWspLink(Get $get, Set $set): void
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

    public static function location_form(): array
    {
        if (getApiStatus(Api::find(2))) {
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
                ->updateLatLng() // update the lat/lng fields on your form when a Place is selected
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
        } elseif (!getApiStatus(Api::find(2))) {
            $location_input = TextInput::make('address')
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
                    TextInput::make('description')
                        ->label('Descripción')
                        ->live(onBlur: true),
                    TextInput::make('reference')
                        ->label('Referencia'),
                    TextInput::make('lat')
                        ->label('Latitud')
                        ->reactive()
                        ->hidden(!getApiStatus(Api::find(2)))
                        ->afterStateUpdated(function ($state, callable $get, callable $set) {
                            $set('location', [
                                'lat' => floatVal($state),
                                'lng' => floatVal($get('lng')),
                            ]);
                        })
                        ->lazy(),
                    TextInput::make('lng')
                        ->label('Longitud')
                        ->reactive()
                        ->hidden(!getApiStatus(Api::find(2)))
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
                        ->hidden(!getApiStatus(Api::find(2)))
                        ->reactive()
                        ->defaultZoom(19)
                        ->mapControls([
                            'zoomControl' => true,
                        ])
                        ->debug()
                        ->drawingControl()
                        ->defaultLocation([-12.0577422, -77.0738183])
                        ->geolocate() // adds a button to request device location and set map marker accordingly
                        ->geolocateLabel('Get Location') // overrides the default label for geolocate button
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


    //common methods
    public static function getHelperText()
    {
        return getApiStatus(Api::find(1)) ? 'Ingrese el número de su documento y se llenará automaticamente si el tipo de documento es RUC ó DNI' : '';
    }

    /**
     * Coloca los valores recibidos por la api APISNET.NET en los campos respectivos
     * dependiendo si se encuentra activado el uso de esta api
     */
    public static function set_data_from_api(Get $get, Set $set): void
    {
        $document_type = $get('id_document_id');
        $document_number = $get('document_number');

        if (getApiStatus(Api::find(1)) == true) {
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
}
