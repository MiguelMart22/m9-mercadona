<?php

namespace App\Events;

use App\Models\Product;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PriceIncreased
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $oldProduct;
    public $newProduct;

    public function __construct(Product $product, $oldPrice, $newPrice)
    {
        $this->product = $product;
        $this->oldPrice = $oldPrice;
        $this->newPrice = $newPrice;
    }

    public function priceIncreased()
    {
        return $this->newProduct->unit_price > $this->oldProduct->unit_price;
    }
}
