<?php

namespace App\Listeners;

use App\Events\OrderJudgeIsShippingEvent;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;

class OrderUpdateIsShipping
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
     * @param \App\Events\OrderJudgeIsShippingEvent $event
     * @return void
     */
    public function handle(OrderJudgeIsShippingEvent $event)
    {
        $ids = $event->orderIds;
        $orders = Order::query()->with('items')->whereIn('id', $ids)->get();
        try {
            DB::beginTransaction();
            $isShippingIds = [];
            foreach ($orders as $order) {
                $items = $order->items;
                $isShipping = [];
                foreach ($items as $item) {
                    $product = $item->product;
                    if ($product->stock >= $item->quantity) {
                        $isShipping[] = true;
                    } else {
                        $isShipping[] = false;
                    }
                }
                if (!!array_product($isShipping)) {
                    $isShippingIds[] = $order->id;
                }
            }
            Order::query()->whereIn('id', $isShippingIds)->update([
                'is_shipping' => 1
            ]);
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
        }


    }
}
