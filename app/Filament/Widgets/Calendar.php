<?php

namespace App\Filament\Widgets;

use App\Models\Meeting;
use App\Traits\Widgets\CalendarTrait;
use Illuminate\Support\Collection;
use Filament\Forms\Form;
use Guava\Calendar\Actions\CreateAction;
use Carbon\Carbon;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Guava\Calendar\Actions\EditAction;
use Guava\Calendar\Widgets\CalendarWidget;

class Calendar extends CalendarWidget
{
    use CalendarTrait;

    protected ?string $locale = 'es';

    protected bool $dateClickEnabled = true;

    protected bool $eventClickEnabled = true;

    protected bool $eventDragEnabled = true;

    public function getEvents(array $fetchInfo = []): Collection | array
    {
        return collect()
            ->push(...Meeting::query()->get());
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
            CreateAction::make('crear reunión')
                ->label('Crear Reunión')
                ->model(Meeting::class),
        ];
    }

    // public function getDateClickContextMenuActions(): array
    // {
    //     return [
    //         CreateAction::make('ctxCreateMeeting')
    //             ->model(Meeting::class)
    //             ->label('Crear Reunión')
    //             ->mountUsing(function (Form $form, array $arguments) {
                    
    //                 $date = data_get($arguments, 'dateStr');
    //                 // dd(Carbon::parse($date)->format('Y-m-d'));
    //                 if ($date) {
    //                     $form->fill([
    //                         'custom_schedules' => false,
    //                         'date' => Carbon::parse($date)->format('M d, Y'),
    //                     ]);
    //                 }
    //             }),
    //     ];
    // }

    public function getDateClickContextMenuActions(): array
    {
        return [
            CreateAction::make('ctxCreateMeeting')
                ->model(Meeting::class)
                ->mountUsing(function (Form $form, array $arguments) {
                    $date = data_get($arguments, 'dateStr');

                    if ($date) {
                        $form->fill([
                            'starts_at' => Carbon::make($date)->setHour(12),
                            'ends_at' => Carbon::make($date)->setHour(13),
                        ]);
                    }
                }),
        ];
    }

    public function getSchema(?string $model = null): ?array
    {
        return self::getCalendarSchema();
    }

    public function getEventClickContextMenuActions(): array
    {
        return [
            $this->viewAction(),
            $this->editAction(),
            $this->deleteAction(),
        ];
    }

    public function onEventDrop(array $info = []): bool
    {
        parent::onEventDrop($info);

        if (in_array($this->getModel(), [Meeting::class])) {
            $record = $this->getRecord();

            if ($delta = data_get($info, 'delta')) {
                $startsAt = $record->starts_at;
                $endsAt = $record->ends_at;
                $startsAt->addSeconds(data_get($delta, 'seconds'));
                $endsAt->addSeconds(data_get($delta, 'seconds'));
                $record->update([
                    'starts_at' => $startsAt,
                    'ends_at' => $endsAt,
                ]);

                Notification::make()
                    ->title('El evento ha sido movido')
                    ->success()
                    ->send()
                ;
            }

            return true;
        }

        return false;
    }

    public function authorize($ability, $arguments = [])
    {
        return true;
    }
}
