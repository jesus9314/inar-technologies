<?php

namespace App\Filament\Widgets;

use App\Models\Meeting;
use App\Services\DateService;
use Guava\Calendar\Widgets\CalendarWidget;
use Illuminate\Support\Collection;
use Filament\Forms\Components;
use Filament\Forms\Form;
use Guava\Calendar\Actions\CreateAction;
use Carbon\Carbon;
use Filament\Forms\Get;
use Filament\Forms\Set;

class Calendar extends CalendarWidget
{
    protected ?string $locale = 'es';

    // protected string $calendarView = 'resourceTimeGridWeek';

    protected bool $dateClickEnabled = true;

    protected bool $eventClickEnabled = true;

    protected bool $eventDragEnabled = true;

    public function getEvents(array $fetchInfo = []): Collection | array
    {
        return collect()
            ->push(...Meeting::query()->get())
            // ->push(...Sprint::query()->get())
        ;
    }

    public function getEventContent(): null | string | array
    {
        return [
            Meeting::class => view('components.calendar.events.meeting'),
        ];
    }

    public function getHeaderActions(): array
    {
        return [
            CreateAction::make('createMeeting')
                ->label('Crear Reunión')
                ->model(Meeting::class),
            // ActionGroup::make([

            // ]),
        ];
    }

    public function getDateClickContextMenuActions(): array
    {
        return [
            CreateAction::make('ctxCreateMeeting')
                ->model(Meeting::class)
                ->label('Crear Reunión')
                ->mountUsing(function (Form $form, array $arguments) {
                    $date = data_get($arguments, 'dateStr');

                    if ($date) {
                        $form->fill([
                            'date' => Carbon::parse($date),
                        ]);
                    }
                }),
        ];
    }

    // protected function prepareForValidation($attributes): array
    // {
    //     // Accedemos a mountedActionsData
    //     $mountedActionsData = $attributes['mountedActionsData'][0];

    //     // Parseamos la fecha y hora para start_time y end_time
    //     $date = Carbon::parse($mountedActionsData['date']);
    //     $startTime = $date->hour((int)$mountedActionsData['starts_at']);
    //     $endTime = $startTime->copy()->addHour();

    //     $dateTimeFormat = 'Y-m-d H:i:s';

    //     // Asignamos los nuevos valores a starts_at y ends_at
    //     $mountedActionsData['starts_at'] = $startTime->format($dateTimeFormat);
    //     $mountedActionsData['ends_at'] = $endTime->format($dateTimeFormat);

    //     // Reasignamos los datos modificados al array attributes
    //     $attributes['mountedActionsData'][0] = $mountedActionsData;

    //     // Retornamos los attributes modificados
    //     dd($attributes);
    //     return $attributes;
    // }

    public function getSchema(?string $model = null): ?array
    {
        $dateFormat = 'Y-m-d';
        return [
            Components\TextInput::make('title')
                ->required(),
            Components\RichEditor::make('description'),
            Components\Group::make([
                Components\DatePicker::make('date')
                    ->label('Fecha')
                    ->minDate(now())->format($dateFormat)
                    ->maxDate(now()->addWeeks(2)->format($dateFormat))
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
                    ->hidden(fn(Get $get) => ! $get('date'))
                    ->required()
                    ->columnSpan(2),
                Components\DateTimePicker::make('starts_at')
                    ->native(false)
                    ->disabled()
                    ->dehydrated(),
                Components\DateTimePicker::make('ends_at')
                    ->native(false)
                    ->disabled()
                    ->dehydrated()

            ]),
            Components\Select::make('users')
                ->relationship('users', 'name')
                ->searchable()
                ->preload()
                ->multiple(),
        ];
    }

    protected static function setMeetingHours(Get $get, Set $set)
    {
        $date = Carbon::parse($get('date'));
        $startTime = $date->hour((int)$get('start_time'));
        $endTime = $startTime->copy()->addHour();
        $dateTimeFormat = 'Y-m-d H:i:s';
        $set('starts_at', $startTime->format($dateTimeFormat));
        $set('ends_at', $endTime->format($dateTimeFormat));
    }

    public function getEventClickContextMenuActions(): array
    {
        return [
            $this->viewAction(),
            $this->editAction(),
            $this->deleteAction(),
        ];
    }

    public function authorize($ability, $arguments = [])
    {
        return true;
    }
}
