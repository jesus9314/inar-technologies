<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class CityBase extends Country
{
    public function suppliers(): BelongsToMany
    {
        return $this->belongsToMany(Supplier::class);
    }
}