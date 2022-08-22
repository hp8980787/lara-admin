<?php

namespace App\Http\Controllers\Bill;

use App\Http\Controllers\ApiBaseController as Controller;
use App\Http\Controllers\Bill\Service\BillService;
use App\Models\BillCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Bill\BillTarit;

class BillCategoryController extends Controller
{
    use BillTarit;

    public array $rules = [];
    public array $message = [];
    public $model;
    public $service;

    public function __construct()
    {
        $this->model = new BillCategory();
        $this->service = new BillService($this->model);

    }

    public function index(Request $request)
    {
        $data = BillCategory::query()->with('columns')->get();
        return $this->success($data);
    }

    public function list()
    {
        $data = BillCategory::query()->active()->with('columns')->get();
        return $this->success($data);
    }

    public function assign(Request $request)
    {
        $category = BillCategory::query()->findOrFail($request->id);
        $columns = $request->columns;
        $category->columns()->sync($columns);
        return $this->success('成功');
    }

}
