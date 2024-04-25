<?php

namespace App\Traits;

use App\Models\Api;
use App\Models\User;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Icetalker\FilamentTableRepeater\Forms\Components\TableRepeater;

trait UserForms
{
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
            TextInput::make('password')
                ->password()
                ->revealable()
                ->hiddenOn(['edit', 'view'])
                ->required()
                ->maxLength(255),
        ];
    }

    public static function get_info_desc(): string
    {
        return self::getStatus() ? 'La información se llenará automáticamente en base al tipo de documento seleccionados [DNI, RUC]' : '';
    }
    public static function getStatus(): bool
    {
        return Api::find(1)->status;
    }

    public static function getHelperText()
    {
        return self::getStatus() ? 'Ingrese el número de su documento y se llenará automaticamente si el tipo de documento es RUC ó DNI' : '';
    }

    public static function set_data_from_api(Get $get, Set $set)
    {
        $document_type = $get('id_document_id');
        $document_number = $get('document_number');

        if (self::getStatus() == true) {
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

    public static function get_user_auth(): User
    {
        return User::find(auth()->user()->id);
    }
}
