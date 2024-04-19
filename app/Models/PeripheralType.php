<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PeripheralType extends Model
{
    use HasFactory;

    protected $fillable = [
        'description'
    ];

    public function peripherals(): HasMany
    {
        return $this->hasMany(Peripheral::class);
    }
}
