<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProcessorSufix extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'processor_manufacturer_id'
    ];

    public function processors(): HasMany
    {
        return $this->hasMany(Processor::class);
    }

    public function processor_manufacturer(): BelongsTo
    {
        return $this->belongsTo(ProcessorManufacturer::class);
    }
}
