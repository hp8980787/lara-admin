<?php

namespace App\Http\Controllers;

use App\Http\Requests\PurchaseRequest;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\ApiBaseController as Controller;

class PurchaseController extends Controller
{
    /*
     * 创建采购订单
     */
    public function store(PurchaseRequest $request): JsonResponse
    {
        $items = is_string($request->items) ? json_decode($request->items, true) : $request->items;
        $items = array_map(fn($v) => json_decode($v, true), $items);
        $now = Carbon::now('Asia/Shanghai');


        try {
            DB::beginTransaction();
            $purchase = Purchase::query()->create([
                'user_id' => $request->user()->id,
                'supplier_id' => $request->supplier_id,
                'title' => $request->title,
                'remark' => $request->remark,
                'deadline_at' => Carbon::parse($request->deadline)->format('Y-m-d H:i:s')
            ]);
            foreach ($items as $k => $item) {

                if ($item['currency'] != 'USD') {
                    $price = round(bcdiv($item['price'], rate($item['currency']), 3), 2);
                    $item['price'] = $price;
                }
                $item['amount'] = bcmul($item['price'], $item['quantity'], 2);
                $item['created_at'] = $now;
                $item['updated_at'] = $now;
                $item['purchase_id'] = $purchase->id;
                unset($item['currency']);
                $items[$k] = $item;
            }
            PurchaseItem::query()->insert($items);
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
        }
        return $this->success('成功');
    }
}
