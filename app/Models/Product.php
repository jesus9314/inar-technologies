<?php

namespace App\Models;

use App\Observers\ProductObserver;
use App\Traits\HasLogActivities;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use TomatoPHP\FilamentLocations\Models\Currency;

#[ObservedBy(ProductObserver::class)]
class Product extends Model
{
    use HasFactory, SoftDeletes, HasLogActivities;

    protected $fillable = [
        'name',
        'secondary_name',
        'slug',
        'model',
        'bar_code',
        'internal_code',
        'due_date',
        'image_url',
        'description',
        'stock_initial',
        'stock_final',
        'stock_min',
        'unity_price',
        'affectation_id',
        'category_id',
        'brand_id',
        'currency_id',
        'unit_id',
        'service_id'
    ];

    public function affectation(): BelongsTo
    {
        return $this->belongsTo(Affectation::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class);
    }

    public function presentations(): HasMany
    {
        return $this->hasMany(Presentation::class);
    }

    public function warehouses(): BelongsToMany
    {
        return $this->belongsToMany(Warehouse::class);
    }

    public function stockHistories(): HasMany
    {
        return $this->hasMany(StockHistory::class);
    }

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function productPurchase(): HasMany
    {
        return $this->hasMany(ProductPurchase::class);
    }

    public function invoicesItems(): HasMany
    {
        return $this->hasMany(InvoicesItem::class);
    }
}
