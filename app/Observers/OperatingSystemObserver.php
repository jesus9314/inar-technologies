<?php

namespace App\Observers;

use App\Models\OperatingSystem;
use Illuminate\Support\Facades\Storage;

class OperatingSystemObserver
{
    /**
     * Handle the OperatingSystem "saved" event.
     */
    public function saved(OperatingSystem $operatingSystem): void
    {
        if($operatingSystem->getOriginal('image_url') != null){
            if($operatingSystem->isDirty('image_url')){
                Storage::disk('public')->delete($operatingSystem->getOriginal('image_url'));
            }
        }
    }

    /**
     * Handle the OperatingSystem "deleted" event.
     */
    public function deleted(OperatingSystem $operatingSystem): void
    {
        if(!is_null($operatingSystem->image_url)){
            Storage::disk('public')->delete($operatingSystem->image_url);
        }
    }
}
