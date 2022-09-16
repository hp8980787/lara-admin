<?php

namespace App\Http\Controllers\Workflow;

use App\Http\Controllers\Workflow\Service\WorkflowService;
use App\Models\WorkflowCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiBaseController as Controller;
use App\Http\Controllers\Workflow\WorkflowTrait;

class CategoryController extends Controller
{
    use WorkflowTrait;

    public $service;
    public $model;
    public array $rules = [
        'store'=>[
            'name'=>'required|min:1|max:30'
        ],
    ];

    public function __construct()
    {
        $this->model = new WorkflowCategory();
        $this->service = new WorkflowService($this->model);
    }

    public function index(Request $request)
    {
        $query = $this->model::query();
        if ($search = $request->search) {
            $query->where('name', 'like', "%$search%");
        }
        $perPage = $request->perPage ?? 10;
        $data = $request->hasPage === true ? $query->paginate($perPage) : $query->get();
        return $this->success($data);
    }
}
