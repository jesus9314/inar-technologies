<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ActivityState extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'description',
    ];

    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }

    public function currencies(): HasMany
    {
        return $this->hasMany(Currency::class);
    }

    public function units(): HasMany
    {
        return $this->hasMany(Unit::class);
    }
}
