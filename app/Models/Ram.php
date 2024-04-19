<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ram extends Model
{
    use HasFactory;

    protected $fillable = [
        'speed',
        'capacity',
        'latency',
        'description',
        'image_url',
        'specifications_link',
        'brand_id',
        'form_factor_id',
        'memory_type_id',

    ];

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function ramFormFactor(): BelongsTo
    {
        return $this->belongsTo(RamFormFactor::class);
    }
    public function memoryType(): BelongsTo
    {
        return $this->belongsTo(MemoryType::class);
    }
}
