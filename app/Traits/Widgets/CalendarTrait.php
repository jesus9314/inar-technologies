<?php

namespace App\Traits\Widgets;

use App\Services\DateService;
use Filament\Forms\Components;
use Carbon\Carbon;
use Filament\Forms\Components\Component;
use Filament\Forms\Get;
use Filament\Forms\Set;
use FilamentTiptapEditor\TiptapEditor;
use HusamTariq\FilamentTimePicker\Forms\Components\TimePickerField;

trait CalendarTrait
{
    protected static $dateFormat = 'M d, Y';

    protected static $dateTimeFormat = 'H:i';

    protected static function getCalendarSchema(): array
    {
        return [
            Components\TextInput::make('title')
                ->required(),
            Components\RichEditor::make('description'),
            Components\Group::make([
                Components\DateTimePicker::make('starts_at')
                    ->native(false)
                    ->seconds(false)
                    ->required(),
                Components\DateTimePicker::make('ends_at')
                    ->native(false)
                    ->seconds(false)
                    ->required(),
            ])->columns(),
            Components\Select::make('users')
                ->relationship('users', 'name')
                ->searchable()
                ->preload()
                ->multiple(),
        ];
    }
}
