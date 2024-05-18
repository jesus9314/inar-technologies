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
    /**
     * MemoryTypeResource
     */
    protected static function memory_type_form(Form $form): Form
    {
        return $form->schema(self::memory_type_schema());
    }

    protected static function memory_type_schema(): array
    {
        return [
            TextInput::make('description')
                ->label('Nombre')
                ->columnSpanFull()
                ->unique(ignoreRecord: true)
                ->required()
                ->maxLength(255),
        ];
    }

    /**
     * RamFormFactorResource
     */
    protected static function ram_form_factor_form(Form $form): Form
    {
        return $form->schema(self::ram_form_factor_schema());
    }

    protected static function ram_form_factor_schema(): array
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
