<?php

namespace App\Models;

use App\Observers\CategoryObserver;
use App\Traits\HasLogActivities;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

#[ObservedBy(CategoryObserver::class)]
class Category extends Model
{
    use HasFactory, HasLogActivities;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'image_url'
    ];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function service(): HasMany
    {
        return $this->hasMany(Service::class);
    }
}
