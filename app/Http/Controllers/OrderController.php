<?php

namespace App\Http\Controllers;

use App\Events\OrderLinkEvent;
use App\Http\Resources\OrderCollection;
use App\Models\Order;
use App\Models\Storehouse;
use App\Models\StorehouseRecord;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiBaseController as Controller;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->perPage ?? 10;
        $query = Order::query()->with('items');
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

        return $this->success('关联成功');
    }

    /**
     *
     * 订单发货
     */
    public function ship(Request $request)
    {
        $order = Order::query()->with('items')->findOrFail($request->order_id);
        $items = $order->items;
        $field = [];
        $success = [];

        foreach ($items as $item) {
            $product = $item->product;
            //查询发货的仓库是否有当前产品库存
            $warehouse = $product->warehouseFind($request->warehouse)->first();
            if ($warehouse) {
                //当前产品在指定仓库有库存，查询库存是否够用
                if ($warehouse->pivot->stock >= $item->quantity) {
                    $product->warehouse()->sync([$warehouse->id => [
                        'stock' => $warehouse->pivot->stock - $item->quantity,
                    ]]);

                    StorehouseRecord::query()->create([
                        'storehouse_id' => $warehouse->id,
                        'product_id' => $product->id,
                        'quantity' => $item->quantity,
                        'status' => 'out',
                        'reviewer' => auth()->user()->id,
                    ]);
                } else {
                    $field[] = $item->id;
                    break;
                }
            } else {
                $field[] = $item->id;
                break;
            }
        }

        if (sizeof($field) > 0) {
            return $this->failed('该仓库库存不够，无法发货');
        }
        $order->status = 1;
        $order->shipping_no = $request->shipping_no;
        $order->shipping_company = $request->shipping_company;
        $order->shipping_price = $request->shipping_price;
        $order->save();
        return $this->success($warehouse);
    }

    /**
     *
     *查看那些仓库可以发货
     * @note 订单不可拆分，所有订单应该是同一仓库发货
     * @params $request->order_id 订单id
     *
     **/
    public function warehouse(Request $request)
    {
        $order = Order::query()->with('items')->findOrFail($request->order_id);
        $items = $order->items;
        $data = [];
        foreach ($items as $item) {
            $product = $item->product;
            $warehouseId = [];
            $warehouses = $product->warehouse;
            if (sizeof($warehouses) > 0) {
                foreach ($warehouses as $warehouse) {
                    if ($warehouse->pivot->stock >= $item->quantity) {
                        $warehouseId[] = $warehouse->id;
                    }
                }
            }
            $data[] = $warehouseId;
        }
        $warehousesId = array_intersect(...$data);
        $warehouseData = Storehouse::query()->whereIn('id', $warehouseId)->get();
        return $this->success($warehouseData);
    }
}
