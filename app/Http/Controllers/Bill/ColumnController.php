<?php

namespace App\Http\Controllers\Bill;

use App\Http\Controllers\Bill\Service\BillService;
use App\Http\Resources\Bill\ColumnCollection;
use App\Models\BillColumn;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiBaseController as Controller;
use App\Http\Controllers\Bill\BillTrait;

class ColumnController extends Controller
{
    use BillTrait;

    public object $model;
    public object $service;

    public array $rules = [
        'store' => [
            'name' => 'required|unique:bill_columns,name|min:3|max:20',
            'label' => 'min:1|max:20',
            'required' => 'required',
            'active' => 'required'
        ],
        'update' => [
            'name' => 'unique:bill_columns,name|min:3|max:20',
            'label' => 'min:1|max:20',
        ]

    ];

    public array $message = [

    ];

    public function __construct()
    {

        $this->model = new BillColumn();
        $this->service = new BillService($this->model);
    }

    public function index(Request $request): JsonResponse
    {

        $query = BillColumn::query();
        if ($search = $request->search) {
            $query->where('name', 'like', "%$search%")
                ->orWhere('label', 'like', "%$search%");
        }
        $perPage = $request->perPage ?? 8;
        $data = $query->paginate($perPage);
        return $this->success(new ColumnCollection($data));
    }


}
