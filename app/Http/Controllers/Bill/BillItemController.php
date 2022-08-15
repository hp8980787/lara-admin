<?php

namespace App\Http\Controllers\Bill;

use App\Models\BillCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiBaseController as Controller;
use App\Http\Controllers\Bill\BillTarit;

class BillItemController extends Controller
{
    use BillTarit;

    public array $rules = [
        'store' => [
            'category_id' => 'required|exists:bill_categories,id',
            'bill_id', 'required|exists:bill,id',
            'amount' => 'required',
            'remark' => 'max:200',
        ]
    ];
    public array $message = [];

    public function store(Request $request)
    {
        $data = $this->initValidate($request, $this->rules[__FUNCTION__], $this->message);
        if (is_string($data)) {
            return $data;
        }
        $billCategory = BillCategory::query()->findOrFail($request->category_id);

        if (sizeof($request->data) > 0) {

        }
    }
}
