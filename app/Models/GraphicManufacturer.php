<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GraphicManufacturer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function graphics(): HasMany
    {
        return $this->hasMany(Graphic::class);
    }

    public function graphicSeries(): HasMany
    {
        return $this->hasMany(GraphicSerie::class);
    }

    public function graphcSufixes(): HasMany
    {
        return $this->hasMany(GraphicSufix::class);
    }
}
