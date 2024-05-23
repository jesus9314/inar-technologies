<?php

namespace App\Observers;

use App\Models\Processor;
use Illuminate\Support\Facades\Storage;

class ProcessorObserver
{
    /**
     * Handle the Processor "saved" event.
     */
    public function saved(Processor $processor): void
    {
        if ($processor->getOriginal('image_url') != null) {
            if ($processor->isDirty('image_url')) {
                Storage::disk('public')->delete($processor->getOriginal('image_url'));
            }
        }
    }

    /**
     * Handle the Processor "deleted" event.
     */
    public function deleted(Processor $processor): void
    {
        if (!is_null($processor->image_url)) {
            Storage::disk('public')->delete($processor->image_url);
        }
    }
}
