<?php

namespace App\Traits\Forms;

use App\Models\Api;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Icetalker\FilamentTableRepeater\Forms\Components\TableRepeater;
use Ysfkaya\FilamentPhoneInput\Forms\PhoneInput;

trait SupplierTraitForms
{
    public static function supplier_type_form(): array
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

    public static function supplier_form(): array
    {
        return [
            Wizard::make()
                ->schema([
                    Step::make('Información Básica')
                        ->schema(self::basic_info_form())
                        ->columns(2),
                    Step::make('Datos adicionales')
                        ->schema(self::aditional_info_form())
                        ->columns(2),
                    Step::make('Correos y teléfonos adicionales')
                        ->schema(self::aditional_mails_phones_form())
                        ->columns(2)
                ])
                ->columnSpanFull()
                ->skippable(),
        ];
    }

    public static function getDataFromApi(Get $get, Set $set): void
    {
        $document_type = $get('id_document_id');
        $document_number = $get('document_number');
        // dd($document_number);

        if (getApiStatus(Api::find(1)) == true) {
            if ($document_type != null && $document_number != null) {
                if ($document_type == 2) {
                    if (strlen($document_number) == 8) {
                        $data = getDataFromDni($document_number);
                        $set('name', "$data->apellidoPaterno $data->apellidoMaterno, $data->nombres");
                    }
                } elseif ($document_type == 4) {
                    if (strlen($document_number) == 11) {
                        $set('name', null);
                        $data = getDataFromRuc($document_number);
                        $set('comercial_name', $data->razonSocial);
                        $set('name', $data->razonSocial);
                    }
                }
            } elseif ($document_type == null) {
                // $set('document_number', null);
                $set('name', null);
            } elseif ($document_number == null) {
                $set('name', null);
                $set('comercial_name', null);
            }
        }
    }

    public static function basic_info_form(): array
    {
        return [
            Select::make('id_document_id')
                ->label('Tipo de documento')
                ->live(onBlur: true)
                ->afterStateUpdated(fn (Get $get, Set $set) => self::getDataFromApi($get, $set))
                ->relationship('idDocument', 'description')
                ->preload()
                ->searchable()
                ->required(),
            TextInput::make('document_number')
                ->live(onBlur: true)
                ->afterStateUpdated(fn (Get $get, Set $set) => self::getDataFromApi($get, $set))
                ->label('Número de documento')
                ->required()
                ->maxLength(255),
            TextInput::make('name')
                ->label('Nombre/Razon Social')
                ->required()
                ->maxLength(255),
            TextInput::make('comercial_name')
                ->label('Nombre Comercial')
                ->required()
                ->maxLength(255)
                ->hidden(fn (Get $get) => $get('id_document_id') != 4),
            Select::make('supplier_type_id')
                ->label('Tipo de proveedor')
                ->relationship('supplierType', 'description')
                ->preload()
                ->searchable()
                ->required(),
            Select::make('countries')
                ->label('Países')
                ->preload()
                ->multiple()
                ->relationship(titleAttribute: 'name')
                ->searchable()
                ->required(),
        ];
    }

    public static function aditional_info_form(): array
    {
        return [
            TextInput::make('web')
                ->label('Página Web')
                ->required()
                ->url()
                ->suffixIcon('heroicon-m-globe-alt')
                ->maxLength(255),
            PhoneInput::make('phone_number')
                ->label('Teléfono Principal')
                ->initialCountry('PE')
                ->autoPlaceholder('polite')
                ->required()
                ->defaultCountry('PE'),
            TextInput::make('address')
                ->label('Dirección')
                ->required()
                ->maxLength(255),
            TextInput::make('email')
                ->label('Correo Electrónico')
                ->email()
                ->required()
                ->maxLength(255),
            FileUpload::make('image_url')
                ->label('Logotipo')
                ->image()
                ->columnSpanFull(),
        ];
    }

    public static function aditional_mails_phones_form(): array
    {
        return [
            TableRepeater::make('phones')
                ->label('Teléfonos')
                ->relationship()
                ->schema([
                    PhoneInput::make('number')
                        ->label('Teléfono')
                        ->initialCountry('PE')
                        ->autoPlaceholder('polite')
                        ->required()
                        ->defaultCountry('PE'),
                    TextInput::make('description')
                        ->label('Descripción')
                        ->required(),
                ])
                ->defaultItems(0),
            TableRepeater::make('emails')
                ->label('Correos Electrónicos')
                ->relationship()
                ->schema([
                    TextInput::make('email')
                        ->label('correo')
                        ->email()
                        ->required()
                        ->maxLength(255),
                ])
                ->defaultItems(0)
        ];
    }
}
