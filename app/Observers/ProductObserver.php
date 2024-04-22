<?php

namespace App\Observers;

use App\Models\Product;
use App\Events\PriceIncreased;

class ProductObserver
{
    /**
     * Handle the Product "created" event.
     */
    public function created(Product $product): void
    {
        //
    }

    /**
     * Handle the Product "updated" event.
     */
    public function updated(Product $product)
    {
        if ($product->isDirty('unit_price') && $product->unit_price > $product->getOriginal('unit_price')) {
            event(new PriceIncreased($product, $product->getOriginal('unit_price'), $product->unit_price));
            echo "Dd";
        }
    }

    /**
     * Handle the Product "deleted" event.
     */
    public function deleted(Product $product): void
    {
        //
    }

    /**
     * Handle the Product "restored" event.
     */
    public function restored(Product $product): void
    {
        //
    }

    /**
     * Handle the Product "force deleted" event.
     */
    public function forceDeleted(Product $product): void
    {
        //
    }
}
