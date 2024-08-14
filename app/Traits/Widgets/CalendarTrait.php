<?php

namespace App\Traits\Widgets;

use App\Services\DateService;
use Filament\Forms\Components;
use Carbon\Carbon;
use Filament\Forms\Get;
use Filament\Forms\Set;
use FilamentTiptapEditor\TiptapEditor;

trait CalendarTrait
{
    protected static $dateFormat = 'Y-m-d';

    protected static $dateTimeFormat = 'Y-m-d H:i:s';

    protected static function getCalendarSchema(): array
    {
        return [
            Components\Wizard::make([
                Components\Wizard\Step::make('Horario')
                    ->schema([
                        Components\ToggleButtons::make('custom_schedules')
                            ->label('Horarios personalizados?')
                            ->columnSpanFull()
                            ->helperText('Si deseas generar un horario personalizado, puedes activar esta opción')
                            ->inline()
                            ->live()
                            ->default(false)
                            ->boolean(),
                        Components\DatePicker::make('date')
                            ->hiddenOn('view')
                            // ->hidden(fn(Get $get) => $get('custom_schedules'))
                            ->columnSpanFull()
                            ->closeOnDateSelection()
                            ->label('Fecha')
                            ->minDate(now())->format(self::$dateFormat)
                            ->maxDate(now()->addWeeks(2)->format(self::$dateFormat))
                            ->afterStateUpdated(function (Get $get, Set $set) {
                                self::setMeetingHours($get, $set);
                            })
                            ->live()
                            ->dehydrated(false)
                            ->native(false)
                            ->required()
                            ->live(),
                        Components\Radio::make('start_time')
                            ->label('Hora de inicio')
                            ->options(fn(Get $get) => (new DateService())->getAvailableTimesForDate($get('date')))
                            ->afterStateUpdated(function (Get $get, Set $set) {
                                self::setMeetingHours($get, $set);
                            })
                            ->dehydrated(false)
                            ->live()
                            ->hidden(fn(Get $get) => self::hideAutoHours($get))
                            ->required()
                            ->columnSpan(2),
                        Components\Group::make([
                            Components\DateTimePicker::make('starts_at')
                                ->disabled(fn(Get $get) => !$get('custom_schedules'))
                                ->hiddenLabel()
                                ->prefix('Inicio')
                                ->hoursStep(2)
                                ->minutesStep(15)
                                ->secondsStep(10)
                                ->native(false)
                                ->dehydrated(),
                            Components\DateTimePicker::make('ends_at')
                                ->disabled(fn(Get $get) => !$get('custom_schedules'))
                                ->hiddenLabel()
                                ->prefix('Final')
                                ->native(false)
                                ->dehydrated(),
                        ])
                            ->columns(2)

                    ]),
                Components\Wizard\Step::make('Datos adicionales')
                    ->schema([
                        Components\TextInput::make('title')
                            ->required(),
                        TiptapEditor::make('description')
                            ->columns(2),
                        Components\Select::make('users')
                            ->relationship('users', 'name')
                            ->searchable()
                            ->preload()
                            ->multiple(),
                    ])
            ])->skippable()

        ];
    }

    protected static function hideAutoHours(Get $get): bool
    {
        if ($get('custom_schedules')) {
            return true;
        } else {
            if ($get('date')) {
                return false;
            } else {
                return true;
            }
        }
    }

    protected static function setMeetingHours(Get $get, Set $set): void
    {
        if (!$get('custom_schedules')) {
            $date = Carbon::parse($get('date'));
            $startTime = $date->hour((int)$get('start_time'));
            $endTime = $startTime->copy()->addHours(2);
            $set('starts_at', Carbon::createFromFormat(self::$dateTimeFormat, $startTime));
            $set('ends_at', Carbon::createFromFormat(self::$dateTimeFormat, $endTime));
        }
    }
}
