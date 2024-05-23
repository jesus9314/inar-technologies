<?php

namespace App\Models;

use App\Observers\BrandObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

#[ObservedBy(BrandObserver::class)]
class Brand extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'image_url'
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable();
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function graphics(): HasMany
    {
        return $this->hasMany(Graphic::class);
    }

    public function rams(): HasMany
    {
        return $this->hasMany(Ram::class);
    }

    public function peripherals(): HasMany
    {
        return $this->hasMany(Peripheral::class);
    }
}
