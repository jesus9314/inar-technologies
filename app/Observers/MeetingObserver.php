<?php

namespace App\Observers;

use App\Models\Meeting;

class MeetingObserver
{
    /**
     * Handle the Meeting "created" event.
     */
    public function creating(Meeting $meeting): void
    {
        // dd($meeting);
    }

    /**
     * Handle the Meeting "updated" event.
     */
    public function updated(Meeting $meeting): void
    {
        //
    }

    /**
     * Handle the Meeting "deleted" event.
     */
    public function deleted(Meeting $meeting): void
    {
        //
    }

    /**
     * Handle the Meeting "restored" event.
     */
    public function restored(Meeting $meeting): void
    {
        //
    }

    /**
     * Handle the Meeting "force deleted" event.
     */
    public function forceDeleted(Meeting $meeting): void
    {
        //
    }
}
