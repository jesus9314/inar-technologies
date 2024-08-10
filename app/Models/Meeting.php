<?php

namespace App\Models;

use App\Observers\MeetingObserver;
use Guava\Calendar\Contracts\Eventable;
use Guava\Calendar\ValueObjects\Event;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

#[ObservedBy(MeetingObserver::class)]
class Meeting extends Model implements Eventable
{
    use HasFactory;

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

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function toEvent(): array | Event
    {
        return Event::make($this)
            ->title($this->title)
            ->start($this->starts_at)
            ->end($this->ends_at)
            ->durationEditable(false)
            ->extendedProp('participants', $this->users()->count())
        ;
    }
}
