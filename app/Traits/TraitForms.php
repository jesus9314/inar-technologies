<?php

namespace App\Traits;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Icetalker\FilamentTableRepeater\Forms\Components\TableRepeater;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;
use Pelmered\FilamentMoneyField\Forms\Components\MoneyInput;
use Pelmered\FilamentMoneyField\Infolists\Components\MoneyEntry;
use Ysfkaya\FilamentPhoneInput\Forms\PhoneInput;

trait TraitForms
{
    protected static function operating_system_form(): array
    {
        return [
            TextInput::make('description')
                ->required()
                ->maxLength(255),
            FileUpload::make('image_url')
                ->image(),
        ];
    }

    protected static function graphics_form(): array
    {
        return [
            TextInput::make('model')
                ->required()
                ->maxLength(255),
            TextInput::make('clock')
                ->required()
                ->maxLength(255),
            TextInput::make('memory_capacity')
                ->required()
                ->maxLength(255),
            FileUpload::make('image_url')
                ->image()
                ->required(),
            TextInput::make('specifications_url')
                ->required()
                ->maxLength(255),
            Select::make('brand_id')
                ->relationship('brand', 'name')
                ->createOptionForm(self::brand_form())
                ->searchable()
                ->preload()
                ->required(),
            Select::make('memory_type_id')
                ->relationship('memoryType', 'description')
                ->createOptionForm(self::memory_type_form())
                ->searchable()
                ->preload()
                ->required(),
        ];
    }

    protected static function peripheral_form(): array
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
                ->createOptionForm(self::brand_form())
                ->searchable()
                ->preload()
                ->required(),
            Select::make('peripheral_type_id')
                ->relationship('peripheralType', 'description')
                ->createOptionForm(self::peripheral_type_form())
                ->searchable()
                ->preload()
                ->required(),
        ];
    }

    protected static function ram_form(): array
    {
        return [
            TextInput::make('speed')
                ->required()
                ->maxLength(255),
            TextInput::make('capacity')
                ->required()
                ->maxLength(255),
            TextInput::make('latency')
                ->maxLength(255),
            Textarea::make('description')
                ->columnSpanFull(),
            FileUpload::make('image_url')
                ->image(),
            TextInput::make('specifications_link')
                ->maxLength(255),
            Select::make('brand_id')
                ->relationship('brand', 'name')
                ->createOptionForm(self::brand_form())
                ->searchable()
                ->preload()
                ->required(),
            Select::make('ram_form_factor_id')
                ->relationship('ramFormFactor', 'description')
                ->createOptionForm(self::ram_form_factor_form())
                ->searchable()
                ->preload()
                ->required(),
            Select::make('memory_type_id')
                ->relationship('memoryType', 'description')
                ->createOptionForm(self::memory_type_form())
                ->searchable()
                ->preload()
                ->required(),
        ];
    }

    protected static function memory_type_form(): array
    {
        return [
            TextInput::make('description')
                ->required()
                ->maxLength(255),
        ];
    }

    protected static function ram_form_factor_form(): array
    {
        return [
            TextInput::make('description')
                ->required()
                ->maxLength(255),
        ];
    }

    protected static function peripheral_type_form(): array
    {
        return [
            TextInput::make('description')
                ->required()
                ->maxLength(255),
        ];
    }

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

    protected static function device_type_form(): array
    {
        return [
            TextInput::make('description')
                ->required()
                ->maxLength(255),
            TextInput::make('symbol')
                ->required()
                ->maxLength(255),
        ];
    }

    protected static function validate_one_field(HasForms $livewire, TextInput $component): void
    {
        $livewire->validateOnly($component->getStatePath());
    }

    protected static function affectation_form(Form $form): Form
    {
        return $form
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
                ->label('Descripción')
                ->required()
                ->maxLength(255),
        ];
    }
}
