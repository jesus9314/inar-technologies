<?php

namespace App\Traits\Forms;

use Filament\Forms\Components\TextInput;

trait ServiceTraitForms
{
    public static function service_form(): array
    {
        return [
            TextInput::make('name')
                ->required()
                ->maxLength(255),
            TextInput::make('slug')
                ->required()
                ->maxLength(255),
            TextInput::make('description')
                ->required()
                ->maxLength(255),
        ];
    }
}
