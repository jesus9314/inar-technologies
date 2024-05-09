<?php

namespace App\Observers;

use App\Models\Brand;
use Illuminate\Support\Facades\Storage;

class BrandObserver
{
    /**
     * Handle the Brand "saved" event.
     */
    public function saved(Brand $brand): void
    {
        // dd($brand);
        if ($brand->getOriginal('image_url') != null) {
            if ($brand->isDirty('image_url')) {
                Storage::disk('public')->delete($brand->getOriginal('image_url'));
            }
        }
    }

    /**
     * Handle the Brand "deleted" event.
     */
    public function deleted(Brand $brand): void
    {
        if (!is_null($brand->image_url)) {
            Storage::disk('public')->delete($brand->image_url);
        }
    }
}
