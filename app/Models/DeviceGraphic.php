<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class DeviceGraphic extends Pivot
{
    use HasFactory;

    public function device(): BelongsTo
    {
        return $this->belongsTo(Device::class);
    }

    public function graphic(): BelongsTo
    {
        return $this->belongsTo(Graphic::class);
    }
}
