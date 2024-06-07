<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Storage extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'auto_name',
        'brand_id',
        'model',
        'socket',
        'chipset',
        'form_factor',
        'ram_support',
        'expansion_slots',
        'io_ports',
        'sata_connectors',
        'features',
        'specs_link'
    ];

    public function devices(): BelongsToMany
    {
        return $this->belongsToMany(Device::class);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function deviceStorages(): HasMany
    {
        return $this->hasMany(DeviceStorage::class);
    }
}
