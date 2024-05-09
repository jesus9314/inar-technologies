<?php

namespace App\Observers;

use App\Models\Category;
use Illuminate\Support\Facades\Storage;

class CategoryObserver
{
    /**
     * Handle the Category "saved" event.
     */
    public function saved(Category $category): void
    {
        // dd($category);
        if ($category->getOriginal('image_url') != null) {
            if ($category->isDirty('image_url')) {
                Storage::disk('public')->delete($category->getOriginal('image_url'));
            }
        }
    }

    /**
     * Handle the Category "deleted" event.
     */
    public function deleted(Category $category): void
    {
        if (!is_null($category->image_url)) {
            Storage::disk('public')->delete($category->image_url);
        }
    }

    /**
     * Handle the Category "restored" event.
     */
    public function restored(Category $category): void
    {
        //
    }
}
