<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class GraphicSufix extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'prority',
        'graphic_manufacturer_id'
    ];

    public function graphics(): BelongsToMany
    {
        return $this->belongsToMany(Graphic::class);
    }

    public function graphicManufacturer(): BelongsTo
    {
        return $this->belongsTo(GraphicManufacturer::class);
    }
}
