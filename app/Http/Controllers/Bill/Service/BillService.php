<?php

namespace App\Http\Controllers\Bill\Service;

use Illuminate\Database\Eloquent\Model;

class BillService
{

    public function __construct(public Model $model)
    {

    }

    public function store(array $data)
    {
        return $this->model->create($data);
    }

    public function destroy($id)
    {
        return $this->model->where('id', $id)->delete();
    }

    public function update(array $data, $id)
    {
        return $this->model->where('id',$id)->update($data);
    }
}
