<?php

namespace App\Traits;

use App\Models\Api;
use App\Models\User;
use Cheesegrits\FilamentGoogleMaps\Fields\Geocomplete;
use Cheesegrits\FilamentGoogleMaps\Fields\Map;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Icetalker\FilamentTableRepeater\Forms\Components\TableRepeater;
use Rawilk\FilamentPasswordInput\Password;
use Illuminate\Support\Str;

trait UserForms
{

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
                    ->visible(self::get_user_auth()->hasRole('super_admin')),
                Step::make('Información adicional')
                    ->schema([
                        TableRepeater::make('phones')
                            ->relationship()
                            ->defaultItems(0)
                            ->schema([
                                TextInput::make('number')
                                    ->required()
                                    ->maxLength(255),
                                TextInput::make('description')
                                    ->columnSpanFull(),
                            ]),
                        TableRepeater::make('emails')
                            ->relationship()
                            ->defaultItems(0)
                            ->schema([
                                TextInput::make('email')
                                    ->email()
                                    ->required()
                                    ->maxLength(255),
                            ])
                    ])
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
                ->afterStateUpdated(fn (Get $get, Set $set) => self::set_data_from_api($get, $set))
                ->helperText(fn () => self::getHelperText())
                ->required()
                ->maxLength(255),
            Select::make('id_document_id')
                ->label('Tipo de documento')
                ->relationship('idDocument', 'description')
                ->afterStateUpdated(fn (Get $get, Set $set) => self::set_data_from_api($get, $set))
                ->searchable()
                ->preload()
                ->live(),
            TextInput::make('name')
                ->label('Nombre/Razón Social')
                ->required()
                ->maxLength(255),
            TextInput::make('last_name_m')
                ->label('Apellido Materno')
                ->hidden(fn (Get $get) => $get('id_document_id') == 4)
                ->maxLength(255),
            TextInput::make('last_name_p')
                ->label('Apellido Paterno')
                ->hidden(fn (Get $get) => $get('id_document_id') == 4)
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
                ->required()
                ->disabledOn('edit')
                ->maxLength(255),
            Password::make('password')
                ->password()
                ->regeneratePassword(color: 'danger')
                ->copyable(color: 'success')
                ->revealable()
                ->hiddenOn(['edit', 'view'])
                ->required()
                ->maxLength(12),
        ];
    }

    public static function get_info_desc(): string
    {
        return self::getApisNetStatus() ? 'La información se llenará automáticamente en base al tipo de documento seleccionados [DNI, RUC]' : '';
    }

    //customer forms
    public static function get_costumer_personal_info_form(): array
    {
        return [
            TextInput::make('document_number')
                ->label('Número de Documento')
                ->live(onBlur: true)
                ->afterStateUpdated(fn (Get $get, Set $set) => self::set_data_from_api($get, $set))
                ->helperText(fn () => self::getHelperText())
                ->required()
                ->maxLength(255),
            Select::make('id_document_id')
                ->label('Tipo de documento')
                ->relationship('idDocument', 'description')
                ->afterStateUpdated(fn (Get $get, Set $set) => self::set_data_from_api($get, $set))
                ->searchable()
                ->preload()
                ->live(),
            TextInput::make('name')
                ->label('Nombre/Razón Social')
                ->required()
                ->maxLength(255),
            TextInput::make('last_name_m')
                ->label('Apellido Materno')
                ->hidden(fn (Get $get) => $get('id_document_id') == 4)
                ->maxLength(255),
            TextInput::make('last_name_p')
                ->label('Apellido Paterno')
                ->hidden(fn (Get $get) => $get('id_document_id') == 4)
                ->maxLength(255),
        ];
    }

    public static function get_costumber_account_info_form(): array
    {
        return [
            TextInput::make('email')
                ->email()
                ->required()
                ->disabledOn('edit')
                ->maxLength(255),
            Password::make('password')
                ->password()
                ->regeneratePassword(color: 'danger')
                ->copyable(color: 'success')
                ->revealable()
                ->hiddenOn(['edit', 'view'])
                ->required()
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

    public static function customer_form(): array
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
                    ->schema(self::location_form())
            ])->columnSpanFull()
                ->skippable(),
        ];
    }

    public static function location_form(): array
    {
        return [
            Repeater::make('locations')
                ->relationship()
                ->schema([
                    TextInput::make('description')
                        ->live(onBlur: true),
                    TextInput::make('lat')
                        ->reactive()
                        ->afterStateUpdated(function ($state, callable $get, callable $set) {
                            $set('location', [
                                'lat' => floatVal($state),
                                'lng' => floatVal($get('longitude')),
                            ]);
                        })
                        ->lazy(),
                    TextInput::make('lng')
                        ->reactive()
                        ->afterStateUpdated(function ($state, callable $get, callable $set) {
                            $set('location', [
                                'lat' => floatval($get('latitude')),
                                'lng' => floatVal($state),
                            ]);
                        })
                        ->lazy(),
                    Geocomplete::make('address')
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
                        ->geolocateIcon('heroicon-o-map'), // override the default icon for the geolocate button
                    Map::make('location')
                        ->columnSpanFull()
                        // ->autocompleteReverse(true) // reverse geocode marker location to autocomplete field
                        ->reactive()
                        ->defaultZoom(19)
                        ->defaultLocation([-12.0577422, -77.0738183])
                        ->geolocate() // adds a button to request device location and set map marker accordingly
                        ->geolocateLabel('Get Location') // overrides the default label for geolocate button
                        // ->geolocateOnLoad(true, true) // geolocate on load, second arg 'always' (default false, only for new form))
                        ->afterStateUpdated(function ($state, callable $get, callable $set) {
                            $set('latitude', $state['lat']);
                            $set('longitude', $state['lng']);
                        }),
                ])
                ->label('Direcciones')
                ->columns(2)
                ->itemLabel(fn (array $state): ?string => Str::upper($state['description']) ?? null)
        ];
    }


    //common methods
    public static function getHelperText()
    {
        return self::getApisNetStatus() ? 'Ingrese el número de su documento y se llenará automaticamente si el tipo de documento es RUC ó DNI' : '';
    }

    /**
     * Coloca los valores recibidos por la api APISNET.NET en los campos respectivos
     * dependiendo si se encuentra activado el uso de esta api
     */
    public static function set_data_from_api(Get $get, Set $set)
    {
        $document_type = $get('id_document_id');
        $document_number = $get('document_number');

        if (self::getApisNetStatus() == true) {
            if ($document_type != null && $document_number != null) {
                if ($document_type == 2) {
                    $data = getDataFromDni($document_number);
                    $set('name', $data->nombres);
                    $set('last_name_m', $data->apellidoMaterno);
                    $set('last_name_p', $data->apellidoPaterno);
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

    /**
     * Obtiene el usuario autenticado
     */
    public static function get_user_auth(): User
    {
        return User::find(auth()->user()->id);
    }

    /**
     * retorna si la api APISNET.NET está habilitada
     */
    public static function getApisNetStatus(): bool
    {
        return Api::find(1)->status;
    }

    /**
     * retorna si la api de Google Maps
     */
    public function getGoogleMapStatus(): bool
    {
        return Api::find(2)->status;
    }
}
