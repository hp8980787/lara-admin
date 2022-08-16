<?php

namespace App\Http\Controllers\Bill;

use App\Http\Controllers\Bill\Service\BillService;
use App\Models\BillCategory;
use App\Models\BillItem;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiBaseController as Controller;
use App\Http\Controllers\Bill\BillTarit;
use Illuminate\Support\Facades\DB;

class BillItemController extends Controller
{
    use BillTarit;


    public array $rules = [
        'store' => [
            'category_id' => 'required|exists:bill_categories,id',
            'bill_id' => 'required|exists:bill,id',
            'amount' => 'required',
            'remark' => 'max:200',
        ]
    ];
    public array $message = [];
    public $service;
    public $model;

    public function __construct()
    {
        $this->model = new BillItem();
        $this->service = new BillService($this->model);
    }

    public function store(Request $request): JsonResponse
    {

        $data = $this->initValidate($request, $this->rules[__FUNCTION__], $this->message);

        if (!is_array($data)) {
            return $data;
        }

        $billCategory = BillCategory::query()->with('columns')->findOrFail($request->category_id);
        $columns = $billCategory->columns;
        $data = [];
        //处理记账字段
        if (sizeof($columns) > 0) {
            //后端有字段值，前端未传值,直接返回错误
            if (!$request->has('data')) return $this->failed('缺少参数', 500);
            $columnsData = json_decode($request->data, true);
            foreach ($columns as $column) {
                //查看后端参数是否和前端传值对应
                if (!in_array($column->name, array_keys($columnsData))) return $this->failed("$column->name 参数不对应请检查", 500);
                $value = $columnsData[$column->name];
                $data = [
                    $column->id => [
                        'value' => $value
                    ]
                ];
            }
        }
        try {
            DB::beginTransaction();;
            $time = now('Asia/Shanghai');

            $bill = BillItem::query()->create([
                'category_id' => $request->category_id,
                'bill_id' => $request->bill_id,
                'amount' => $request->amount,
                'remark' => $request->remark,
                'writer' => auth()->user()->id,
                'status' => $request->status,
                'day' => $time->day,
                'week' => $time->week,
                'month' => $time->month,
                'year' => $time->year,

            ]);
            if (sizeof($data) > 0) {
                $billItem = BillItem::query()->findOrFail($bill->id);
                $billItem->values()->sync($data);
            }
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();

        }
        return $this->success('添加成功');
    }
}
