<?php

namespace App\Traits\Widgets;

use AmidEsfahani\FilamentTinyEditor\TinyEditor;
use App\Models\Meeting;
use App\Traits\Forms\CommonForms;
use Filament\Forms\Components;
use Filament\Forms;

trait CalendarTrait
{
    protected static $dateFormat = 'M d, Y';

    protected static $dateTimeFormat = 'H:i';

    protected static function getCalendarSchema(): array
    {
        return [
            Components\TextInput::make('title')
                ->label('Título')
                ->required()
                ->default(fn() => "Cita #" . (\App\Models\Meeting::count() + 1))
                ->disabled(fn(Forms\Get $get) => $get('editTittle') ? false : true)
                ->columnSpan(2)
                ->dehydrated(),
            Components\Section::make('tittle')
                ->description('Desea ingresar manualmente el título?, abra esta sección')
                ->columnSpanFull()
                ->collapsed()
                ->collapsible()
                ->schema([
                    Components\ToggleButtons::make('editTittle')
                        ->default(false)
                        ->label('Título manual')
                        ->inline()
                        ->dehydrated(false)
                        ->boolean()
                        ->live()
                ]),
            Components\Group::make([
                Components\DateTimePicker::make('starts_at')
                    ->label('Inicio')
                    ->native(false)
                    ->seconds(false)
                    ->required(),
                Components\DateTimePicker::make('ends_at')
                    ->label('Final')
                    ->native(false)
                    ->seconds(false)
                    ->required(),
            ])->columnSpanFull(),
            TinyEditor::make('description')
                ->label('Descripción')
                ->profile('default')
                ->resize('both'),
            Components\Select::make('customer')
                ->label('Dueño')
                ->searchable()
                ->preload()
                ->native(false)
                ->getSearchResultsUsing(function (string $search) {
                    return \App\Models\Customer::query()
                        ->where('name', 'like', "%{$search}%")
                        ->orWhere('document_number', 'like', "%{$search}%")
                        ->get()
                        ->mapWithKeys(function ($item) {
                            return [$item->id => $item->display_name];
                        });
                })
                ->getOptionLabelUsing(function ($value) {
                    return \App\Models\Customer::find($value)?->display_name;
                })
        ];
    }
}
