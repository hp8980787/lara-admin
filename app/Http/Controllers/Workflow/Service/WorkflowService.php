<?php

namespace App\Http\Controllers\Workflow\Service;

use Illuminate\Database\Eloquent\Model;

class WorkflowService
{
    public function __construct(public Model $model)
    {

    }

    public function store(array $data)
    {
        return $this->model->create($data);
    }

    public function update(array $data, $id)
    {
        return $this->model->where('id', $id)->update($data);
    }

    public function destroy($id)
    {
        return $this->model->where('id', $id)->delete();
    }


}
