<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProcessorSerie extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'processor_manufacturer_id'
    ];

    public function processorManufacturer(): BelongsTo
    {
        return $this->belongsTo(ProcessorManufacturer::class);
    }

    public function processors(): HasMany
    {
        return $this->hasMany(Processor::class);
    }
}
