<?php

namespace App\Listeners;

use App\Events\OrderJudgeIsShippingEvent;
use App\Events\OrderLinkEvent;
use App\Models\Order;
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
                        if ($res = OrderItem::query()->where('product_id', $product->id)->where('order_id', $order->id)->first()) {
                            $res->update([
                                'product_id' => $product->id,
                                'order_id' => $order->id,
                                'quantity' => $code[1],
                            ]);
                        } else {
                            OrderItem::query()->create([
                                'product_id' => $product->id,
                                'order_id' => $order->id,
                                'quantity' => $code[1],
                            ]);
                        }
                        $array[] = true;
                    } else {
                        $array[] = false;
                        $faildId[] = $order->id;
                    }
                }

                if (!!array_product($array)) {
                    $successId[] = $order->id;
                }

            }
        }
        //设置订单连接状态
        Order::query()->whereIn('id', $successId)->update([
            'link_status' => 1,
        ]);
        Order::query()->whereIn('id', $faildId)->update([
            'link_status' => -1,
        ]);

        OrderJudgeIsShippingEvent::dispatch($successId);

    }
}

