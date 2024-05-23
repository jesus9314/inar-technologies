<?php

namespace App\Models;

use App\Observers\ProcessorObserver;
use App\Traits\HasLogActivities;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[ObservedBy(ProcessorObserver::class)]
class Processor extends Model
{
    use HasFactory, HasLogActivities;

    protected $fillable = [
        'name',
        'slug',
        'model',
        'cores',
        'threads',
        'socket',
        'auto_name',
        'tdp',
        'integrated_graphics',
        'memory_capacity',
        'description',
        'image_url',
        'specifications_url',
        'processor_sufix_id',
        'processor_generation_id',
        'processor_manufacturer_id',
        'processor_serie_id',
        'brand_id',
        'processor_condition_id',
        'memory_type_id'
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function processorCondition(): BelongsTo
    {
        return $this->belongsTo(ProcessorCondition::class);
    }

    public function memoryType(): BelongsTo
    {
        return $this->belongsTo(MemoryType::class);
    }

    public function device(): HasMany
    {
        return $this->hasMany(Device::class);
    }

    public function processorManufacturer(): BelongsTo
    {
        return $this->belongsTo(ProcessorManufacturer::class);
    }

    public function processorSerie(): BelongsTo
    {
        return $this->belongsTo(processorSerie::class);
    }

    public function processorSufix(): BelongsTo
    {
        return $this->belongsTo(processorSufix::class);
    }

    public function processorGeneration(): BelongsTo
    {
        return $this->belongsTo(ProcessorGeneration::class);
    }
}
