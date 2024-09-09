<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use TomatoPHP\FilamentInvoices\Models\InvoicesItem as BaseInvoiceItems;

class InvoicesItem extends BaseInvoiceItems
{
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
