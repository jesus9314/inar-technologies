<?php

namespace App\Observers;

use App\Models\Graphic;
use Illuminate\Support\Facades\Storage;

class GraphicObserver
{
    /**
     * Handle the Graphic "saved" event.
     */
    public function saved(Graphic $graphic): void
    {
        if ($graphic->getOriginal('image_url') != null) {
            if ($graphic->isDirty('image_url')) {
                Storage::disk('public')->delete($graphic->getOriginal('image_url'));
            }
        }
    }

    /**
     * Handle the Graphic "deleted" event.
     */
    public function deleted(Graphic $graphic): void
    {
        if (!is_null($graphic->image_url)) {
            Storage::disk('public')->delete($graphic->image_url);
        }
    }
}
