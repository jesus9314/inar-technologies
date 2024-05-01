<?php

namespace App\Observers;

use App\Models\Product;
use App\Models\ProductPurchase;
use App\Models\StockHistory;

class ProductPurchaseObserver
{
    /**
     * Handle the ProductPurchase "created" event.
     */
    public function created(ProductPurchase $productPurchase): void
    {
       $product=Product::find($productPurchase->product_id);
       $old_quantity = $product->stock_final;
       $product->stock_final += $productPurchase->quantity;
       $product->save();

        StockHistory::create([
            'old_quantity' => $old_quantity,
            'new_quantity' => $product->stock_final,
            'total_price' => $product->unity_price,
            'product_id' => $productPurchase->product_id,
            'action_id' => 2,
        ]);
    }
}
