<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GraphicSerie extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'prefix',
        'graphic_manufacturer_id'
    ];

    public function graphics(): HasMany
    {
        return $this->hasMany(Graphic::class);
    }

    public function graphicManufacturer(): BelongsTo
    {
        return $this->belongsTo(GraphicManufacturer::class);
    }
}
