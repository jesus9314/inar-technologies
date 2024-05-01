<?php

namespace App\Observers;

use App\Models\Product;
use App\Models\ProductPurchase;
use App\Models\Purchase;
use App\Models\StockHistory;
use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;
use Illuminate\Support\Facades\DB;

class PurchaseObserver implements ShouldHandleEventsAfterCommit
{
    // private $productPurchase;

    // public function __construct(ProductPurchase $productPurchase)
    // {
    //     $this->productPurchase = $productPurchase;
    // }

    /**
     * Handle the Purchase "saved" event.
     */
    public function created(Purchase $purchase): void
    {
        // dd($purchase);
        // // $this_purchase = DB::table('product_purchase')->where('id',$purchase->id )->get();
        // $productosAsignados = $purchase->productPurchase->pluck('product_id');
        // // dd($purchase);
        // if ($purchase->products) {
        //     foreach ($purchase->products as $product) {
        //         $product_to_update = Product::find($product->id);
        //         $product_to_update->stock_final += $product->quantity;
        //         StockHistory::create([
        //             'quantity' => $product_to_update->stock_final,
        //             'product_id' => $product->id,
        //             'action_id' => 2,
        //         ]);
        //     }
        // }
    }

    /**
     * Handle the Purchase "updated" event.
     */
    public function updated(Purchase $purchase): void
    {
        //
    }

    /**
     * Handle the Purchase "deleted" event.
     */
    public function deleted(Purchase $purchase): void
    {
        //
    }

    /**
     * Handle the Purchase "restored" event.
     */
    public function restored(Purchase $purchase): void
    {
        //
    }

    /**
     * Handle the Purchase "force deleted" event.
     */
    public function forceDeleted(Purchase $purchase): void
    {
        //
    }
}
