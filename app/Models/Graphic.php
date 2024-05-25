<?php

namespace App\Models;

use App\Observers\GraphicObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

#[ObservedBy(GraphicObserver::class)]
class Graphic extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'auto_name',
        'model',
        'clock',
        'memory_capacity',
        'image_url',
        'specifications_url',
        'memory_type_id',
        'graphic_manufacturer_id',
        'graphic_serie_id'
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function memoryType(): BelongsTo
    {
        return $this->belongsTo(MemoryType::class);
    }

    public function graphicManufacturer(): BelongsTo
    {
        return $this->belongsTo(GraphicManufacturer::class);
    }

    public function graphicSerie(): BelongsTo
    {
        return $this->belongsTo(GraphicSerie::class);
    }

    public function graphicSufix(): BelongsToMany
    {
        return $this->belongsToMany(GraphicSufix::class);
    }
}
