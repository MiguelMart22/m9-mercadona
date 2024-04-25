<?php
namespace App\Observers;

use App\Models\Product;
use App\Events\PriceIncreased;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ProductObserver
{
    /**
     * Handle the Product "updated" event.
     */
    public function updated(Product $product)
    {
        if ($product->isDirty('unit_price') && $product->unit_price > $product->getOriginal('unit_price')) {
            $this->sendDiscordMessage("El precio del producto '{$product->display_name}' ha aumentado a {$product->unit_price}.\n");
        }
    }

    /**
     * Send a message to Discord.
     */
    private function sendDiscordMessage(string $message)
    {
        // Discord Webhook URL
        $webhookUrl = 'https://discord.com/api/webhooks/1233116426148122868/4L0O9ZU6z7aUAZXkzmTRozqUw5OjEZYGuRbwuyD33RoFh5Yp0ROew43nAOdAeIrPUS7L';

        // Prepare payload
        $payload = [
            'content' => $message,
        ];

        // Send POST request to Discord webhook
        $response = Http::post($webhookUrl, $payload);

    }
}
