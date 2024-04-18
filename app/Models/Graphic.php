<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Graphic extends Model
{
    use HasFactory;

    protected $fillable = [
        'model',
        'clock',
        'memory_capacity',
        'image_url',
        'specifications_url',
        'brand_id',
        'memory_type_id'
    ];

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function memoryType(): BelongsTo
    {
        return $this->belongsTo(MemoryType::class);
    }
}
