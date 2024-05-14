<?php

namespace App\Models;

use App\Observers\PurchaseObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

#[ObservedBy(PurchaseObserver::class)]
class Purchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'date_of_issue',
        'date_of_reception',
        'price',
        'igv',
        'total_price',
        'series',
        'number',
        'tax_document_type_id',
        'supplier_id',
        'currency_id',
        'action_id'
    ];

    public function taxDocumentType(): BelongsTo
    {
        return $this->belongsTo(TaxDocumentType::class);
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class);
    }

    public function action(): BelongsTo
    {
        return $this->belongsTo(Action::class);
    }

    public function vouchers(): MorphMany
    {
        return $this->morphMany(Voucher::class, 'voucherable');
    }

    public function productPurchase(): HasMany
    {
        return $this->hasMany(ProductPurchase::class);
    }

    public function purchaseService(): HasMany
    {
        return $this->hasMany(PurchaseService::class);
    }

    public function scopeWithProducts($query)
    {
        $query->with('productPurchase');
    }
}
