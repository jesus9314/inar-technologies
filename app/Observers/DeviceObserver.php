<?php

namespace App\Observers;

use App\Models\Device;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class DeviceObserver
{
    /**
     * Handle the Device "saved" event.
     */
    public function saved(Device $device): void
    {
        if ($device->getOriginal('speccy_snapshot_url') != null) {
            if ($device->isDirty('speccy_snapshot_url')) {
                Storage::disk('public')->delete($device->getOriginal('speccy_snapshot_url'));
            }
        }
    }

    /**
     * Handle the Device "deleted" event.
     */
    public function deleted(Device $device): void
    {
        if (!is_null($device->speccy_snapshot_url)) {
            Storage::disk('public')->delete($device->speccy_snapshot_url);
        }
    }
}
