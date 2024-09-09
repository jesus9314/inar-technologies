<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use TomatoPHP\FilamentLocations\Models\Location as BaseLocation;

class Location extends BaseLocation
{
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
}
