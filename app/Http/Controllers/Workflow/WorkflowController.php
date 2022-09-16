<?php

namespace App\Http\Controllers\Workflow;

use App\Http\Controllers\ApiBaseController as Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Workflow\WorkflowTrait;
use App\Http\Controllers\Workflow\Service\WorkflowService;
use App\Models\Workflow;

class WorkflowController extends Controller
{
    use WorkflowTrait;

    public object $service;
    public object $model;
    public array $rules = [
        'store' => [
            'name' => 'required|unique:workflow,name',
            'category_id' => 'required',
        ]
    ];

    public function __construct()
    {
        $this->model = new Workflow();
        $this->service = new WorkflowService($this->model);
    }

}
