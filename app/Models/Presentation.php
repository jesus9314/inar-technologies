<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Presentation extends Model
{
    use HasFactory;

    protected $fillable = [
        'bar_code',
        'description',
        'factor',
        'price',
        'product_id',
    ];

    public function productPurchases(): HasMany
    {
        return $this->hasMany(ProductPurchase::class);
    }
}
