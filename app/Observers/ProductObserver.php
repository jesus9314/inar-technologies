<?php

namespace App\Observers;

use App\Models\Product;
use App\Models\StockHistory;

class ProductObserver
{
    /**
     * Handle the Product "created" event.
     */
    public function created(Product $product): void
    {
        StockHistory::create([
            'old_quantity' => 0,
            'new_quantity' => $product->stock_initial,
            'total_price' => $product->unity_price,
            'product_id' => $product->id,
            'action_id' => 1,
        ]);
        $product->stock_final = $product->stock_initial;
        $product->save();
    }
}
