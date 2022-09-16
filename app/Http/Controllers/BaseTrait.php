<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

trait BaseTrait
{
    /**
     *
     * @note 表单验证
     *
     * @return  array|JsonResponse $data
     */
    public function initValidate(Request $request, array $rules = [], array $message = [])
    {
        $validator = Validator::make($request->all(), $rules, $message);

        if ($validator->fails()) {
            $errors = $validator->errors()->messages();
            $message = array_pop($errors)[0];
            return $this->failed($message);
        }
        $data = $request->only($this->model->getFillable());
        return $data;
    }


    public function store(Request $request): JsonResponse
    {
        $data = $this->initValidate($request, $this->rules[__FUNCTION__] ?? []);
        if (!is_array($data)) {
            return $data;
        }
        $this->service->store($data);
        return $this->success('添加成功');
    }

    public function update(Request $request, $id): JsonResponse
    {
        $data = $this->initValidate($request, $this->rules[__FUNCTION__] ?? []);
        if (!is_array($data)) {
            return $data;
        }
        $this->service->update($data, $id);
        return $this->success('更新成功');

    }

    public function destroy($id)
    {
        $this->service->destroy($id);
        return $this->success('删除成功');
    }
}
