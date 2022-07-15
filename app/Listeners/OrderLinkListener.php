<?php

namespace App\Listeners;

use App\Events\OrderLinkEvent;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class OrderLinkListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param \App\Events\OrderLinkEvent $event
     * @return void
     */
    public function handle(OrderLinkEvent $event): void
    {
        $orders = $event->orders;
        $faildId = [];
        $successId = [];
        foreach ($orders as $order) {
            if ($order->product_code) {
                $productCodes = array_map(fn($val) => explode('|', $val), array_filter(explode(',', $order->product_code)));

                $array = [];
                foreach ($productCodes as $code) {
                    $sku = $code[0];
                    $quantity = $code[1];
                    $product = Product::query()->where('pcode', 'like', "%$sku%")
                        ->orWhere('pcodes', 'like', "%$sku%")->first();
                    if ($product) {
//                        OrderItem::query()->create([
//                            'product_id' => $product->id,
//                            'order_id' => $order->id,
//                            'quantity' => $code[1],
//                        ]);
                        $array['id'] = $order->id;
                        $successId[] = $array;
                    } else {
                        $faildId[] = $order->id;
                    }
                }

            }
        }

        dd($successId);

    }
}

