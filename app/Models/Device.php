<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Device extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'aditional_info',
        'ram_total',
        'speccy_snapshot_url',
        'device_state_id',
        'processor_id',
    ];

    public function deviceState(): BelongsTo
    {
        return $this->belongsTo(DeviceState::class);
    }

    public function processor()
    {
        return $this->belongsTo(Processor::class);
    }

    public function deviceOperatingSystems(): HasMany
    {
        return $this->hasMany(DeviceOperatingSystem::class);
    }

    public function deviceGraphics(): HasMany
    {
        return $this->hasMany(DeviceGraphic::class);
    }

    public function devicePeripherals(): HasMany
    {
        return $this->hasMany(DevicePeripheral::class);
    }

    public function deviceRams(): HasMany
    {
        return $this->hasMany(DeviceRam::class);
    }
}
