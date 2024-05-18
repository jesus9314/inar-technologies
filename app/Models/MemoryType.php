<?php

namespace App\Models;

use App\Traits\HasLogActivities;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MemoryType extends Model
{
    use HasFactory, HasLogActivities;

    protected $fillable = [
        'description'
    ];

    public function processors(): HasMany
    {
        return $this->hasMany(Processor::class);
    }

    public function graphics(): HasMany
    {
        return $this->hasMany(Graphic::class);
    }

    public function rams()
    {
        return $this->hasMany(Ram::class);
    }
}
