<?php

namespace App\Http\Controllers;

use App\Events\OrderLinkEvent;
use App\Http\Resources\OrderCollection;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiBaseController as Controller;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->perPage ?? 10;
        $query = Order::query();
        if ($search = $request->search) {
            $query->where('trans_id', 'like', "%$search%")
                ->orWhere('order_number', 'like', "%$search%")
                ->orWhere('name', 'like', "%$search%")
                ->orWhere('phone', 'like', "%$search%")
                ->orWhere('email', 'like', "%$search%")
                ->orWhere('postal', 'like', "%$search%")
                ->orWhere('city', 'like', "%$search%")
                ->orWhere('street1', 'like', "%$search%")
                ->orWhere('description', 'like', "%$search%")
                ->orWhere('ip', 'like', "%$search%");
        }
        $orders = $query->paginate($perPage);
        return $this->success(new OrderCollection($orders));
    }

    public function update(Request $request, $id)
    {
        $order = Order::query()->findOrFail($id);
        $order->product_code = strval($request->product_code);
        $order->save();
        return $this->success($order);
    }

    /**
     *
     * 订单产品和仓库产品链接
     *
     */
    public function linkProducts(Request $request)
    {
        $orders = Order::query()->whereIn('id', $request->id)->get();
        OrderLinkEvent::dispatch($orders);
        return $this->success($request->id);
    }
}
