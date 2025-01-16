<?php

namespace App\Models;

use App\Observers\WarehouseObserver;
use App\Traits\HasLogActivities;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[ObservedBy([WarehouseObserver::class])]
class Warehouse extends Model
{
    use HasFactory, HasLogActivities;

    protected $fillable = [
        'description',
        'stablishment',
        'code',
        'location'
    ];

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }

    public function document(): HasMany
    {
        return $this->hasMany(Document::class);
    }
}
