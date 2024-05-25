<?php

namespace App\Models;

use App\Observers\DeviceObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

// #[ObservedBy([DeviceObserver::class])]
class Device extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'identifier',
        'description',
        'aditional_info',
        'ram_total',
        'speccy_snapshot_url',
        'device_state_id',
        'processor_id',
        'device_id',
        'device_type_id',
        'user_id'
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

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

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function deviceType(): BelongsTo
    {
        return $this->belongsTo(DeviceType::class);
    }

    public function maintenances(): HasMany
    {
        return $this->hasMany(Maintenance::class);
    }
}
