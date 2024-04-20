<?php

namespace App\Traits;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Set;
use Illuminate\Support\Str;

trait TraitForms
{
    public static function brand_form(): array
    {
        return [
            TextInput::make('name')
                ->required()
                ->live(onBlur: true)
                ->columnSpan([
                    'default' => 1,
                    'md' => 1,
                ])
                ->afterStateUpdated(fn (Set $set, $state) => $set('slug', Str::slug($state)))
                ->maxLength(255),
            TextInput::make('slug')
                ->readOnly()
                ->columnSpan([
                    'default' => 1,
                    'md' => 1,
                ])
                ->required()
                ->maxLength(255),
            Textarea::make('description')
                ->columnSpan([
                    'default' => 1,
                    'md' => 1,
                ])
                ->columnSpanFull(),
            FileUpload::make('image_url')
                ->columnSpan([
                    'default' => 1,
                    'md' => 1,
                ])
                ->image(),
        ];
    }

    public static function operating_system_form(): array
    {
        return [
            TextInput::make('description')
                ->required()
                ->maxLength(255),
            FileUpload::make('image_url')
                ->image(),
        ];
    }

    public static function graphics_form(): array
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
                ->createOptionForm(self::just_description())
                ->searchable()
                ->preload()
                ->required(),
        ];
    }

    public static function peripheral_form(): array
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
                ->createOptionForm(self::just_description())
                ->searchable()
                ->preload()
                ->required(),
        ];
    }

    public static function ram_form(): array
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
                ->createOptionForm(self::just_description())
                ->searchable()
                ->preload()
                ->required(),
            Select::make('memory_type_id')
                ->relationship('memoryType', 'description')
                ->createOptionForm(self::just_description())
                ->searchable()
                ->preload()
                ->required(),
        ];
    }

    public static function just_description(): array
    {
        return [
            TextInput::make('description')
                ->required()
                ->maxLength(255),
        ];
    }
}
