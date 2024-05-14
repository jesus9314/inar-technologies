<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Affectation extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'description'
    ];

    public function products() : HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function service(): HasMany
    {
        return $this->hasMany(Service::class);
    }
}
