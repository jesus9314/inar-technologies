<?php

namespace App\Observers;

use App\Models\Peripheral;
use Illuminate\Support\Facades\Storage;

class PeripheralOsberver
{
    /**
     * Handle the Peripheral "saved" event.
     */
    public function saved(Peripheral $peripheral): void
    {
        //
        if ($peripheral->getOriginal('image_url') != null) {
            if ($peripheral->isDirty('image_url')) {
                Storage::disk('public')->delete($peripheral->getOriginal('image_url'));
            }
        }
    }

    /**
     * Handle the Peripheral "deleted" event.
     */
    public function deleted(Peripheral $peripheral): void
    {
        if (!is_null($peripheral->image_url)) {
            Storage::disk('public')->delete($peripheral->image_url);
        }
    }
}
