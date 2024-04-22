<?php

namespace App\Observers;

use App\Models\Product;
use App\Events\PriceIncreased;
use Telegram\Bot\Api;

class ProductObserver
{
    /**
     * Handle the Product "updated" event.
     */
    public function updated(Product $product)
    {
        if ($product->isDirty('unit_price') && $product->unit_price > $product->getOriginal('unit_price')) {
            $this->sendTelegramMessage("El precio del producto '{$product->display_name}' ha aumentado a {$product->unit_price}. - Miguel Martinez");
        }
    }

    /**
     * Send a message to Telegram.
     */
    private function sendTelegramMessage(string $message)
    {
        // Initialize Telegram Bot API
        $telegram = new Api(config('services.telegram.bot_token'));

        // Send message to your bot chat
        $telegram->sendMessage([
            'chat_id' => config('services.telegram.chat_id'),
            'text' => $message,
        ]);
    }
}
