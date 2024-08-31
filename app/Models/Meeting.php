<?php

namespace App\Models;

use App\Observers\MeetingObserver;
use App\Traits\Models\MeetingTrait;
use App\Traits\Widgets\CalendarTrait;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Carbon\Carbon;
use Guava\Calendar\Contracts\Eventable;
use Guava\Calendar\ValueObjects\Event;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

#[ObservedBy(MeetingObserver::class)]
class Meeting extends Model implements Eventable
{
    use HasFactory, MeetingTrait;

    protected $fillable = [
        'title',
        'description',
        'starts_at',
        'ends_at',
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function toEvent(): array | Event
    {
        $data = [
            'bgColor' => self::getBgColorByDate($this->ends_at),
            'extendedProps' => [
                'starts_at' => self::getHourFormat($this->starts_at),
                'end_hour' => self::getHourFormat($this->ends_at),
                'borderColor' => self::getBorderClass($this->ends_at),
                'textColor' => self::getHourColor($this->ends_at),
            ]
        ];
        return Event::make($this)
            ->backgroundColor($data['bgColor'])
            ->title($this->title)
            ->start(self::getHourFormat($this->starts_at))
            ->end(self::getHourFormat($this->ends_at))
            ->durationEditable(false)
            ->extendedProps($data['extendedProps'])
        ;
    }
}
