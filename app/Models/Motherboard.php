<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Motherboard extends Model
{
    use HasFactory;

    protected $fillable  = [
        'name',
        'slug',
        'model',
        'form_factor',
        'socket',
        'chipset',
        'auto_name',
        'expansion_slots',
        'io_ports',
        'features',
        'brand_id',
        'specs_link',
    ];

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function devices(): HasMany
    {
        return $this->hasMany(Device::class);
    }
}
