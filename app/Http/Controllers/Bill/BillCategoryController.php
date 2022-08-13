<?php

namespace App\Http\Controllers\Bill;

use App\Http\Controllers\ApiBaseController as Controller;
use App\Models\BillCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Bill\BillTarit;

class BillCategoryController extends Controller
{
    use BillTarit;
    public array $rules=[];
    public array $message=[];


    public function index(Request $request)
    {
        $data = BillCategory::query()->get();
        return $this->success($data);
    }

    public function store(Request $request)
    {
        $data = $request->only('description', 'name', 'status');
        BillCategory::query()->create($data);
        return $this->success('成功');
    }
}
