<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProcessorManufacturer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function processors(): HasMany
    {
        return $this->hasMany(Processor::class);
    }

    public function processorSeries(): HasMany
    {
        return $this->hasMany(ProcessorSerie::class);
    }

    public function processorSufixes(): HasMany
    {
        return $this->hasMany(ProcessorSufix::class);
    }

    public function generations(): HasMany
    {
        return $this->hasMany(ProcessorGeneration::class);
    }
}
