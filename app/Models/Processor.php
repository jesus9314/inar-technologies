<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Processor extends Model
{
    use HasFactory;

    protected $fillable = [
        'model',
        'generation',
        'cores',
        'socket',
        'tdp',
        'integrated_graphics',
        'memory_capacity',
        'description',
        'image_url',
        'specifications_url',
        'brand_id',
        'processor_condition_id',
        'memory_type_id'
    ];

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
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
}
