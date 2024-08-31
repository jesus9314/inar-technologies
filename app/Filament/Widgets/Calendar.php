<?php

namespace App\Filament\Widgets;

use App\Models\Customer;
use App\Models\Device;
use App\Models\Meeting;
use App\Traits\Forms\CommonForms;
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
    use CalendarTrait, CommonForms;

    protected ?string $locale = 'es';

    protected bool $dateClickEnabled = true;

    protected bool $eventClickEnabled = true;

    protected bool $eventDragEnabled = true;

    public static function canView(): bool
    {
        return true;
    }

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
            CreateAction::make('createMeeting')
                ->label('Agendar Cita')
                ->color('danger')
                ->modalHeading('Agendar Cita')
                ->icon('heroicon-o-user-group')
                ->closeModalByClickingAway(false)
                ->stickyModalHeader()
                ->stickyModalFooter()
                ->slideOver()
                ->modal()
                ->model(Meeting::class),
            CreateAction::make('createCustomer')
                ->label('Nuevo Cliente')
                ->modalHeading('Nuevo Cliente')
                ->closeModalByClickingAway(false)
                ->stickyModalHeader()
                ->stickyModalFooter()
                ->slideOver()
                ->color('success')
                ->icon('heroicon-s-user')
                ->model(Customer::class),
            CreateAction::make('createDevice')
                ->label('Nuevo Dispositivo')
                ->modalHeading('Nuevo Dispositivo')
                ->closeModalByClickingAway(false)
                ->stickyModalHeader()
                ->stickyModalFooter()
                ->slideOver()
                ->color('warning')
                ->icon('heroicon-o-computer-desktop')
                ->model(Device::class)
        ];
    }

    public function getDateClickContextMenuActions(): array
    {
        return [
            CreateAction::make('ctxCreateMeeting')
                ->model(Meeting::class)
                ->color('danger')
                ->modalHeading('Agendar Cita')
                ->icon('heroicon-o-user-group')
                ->closeModalByClickingAway(false)
                ->stickyModalHeader()
                ->stickyModalFooter()
                ->slideOver()
                ->label('Agendar Cita')
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
        // return self::getCalendarSchema();

        return match ($model) {
            Meeting::class => self::getCalendarSchema(),
            Customer::class => self::customer_schema(),
            Device::class => self::device_schema()
        };
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
