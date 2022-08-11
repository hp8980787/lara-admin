<?php

namespace App\Http\Controllers\Bill;

use App\Http\Controllers\ApiBaseController as Controller;
use App\Models\Bill;
use Illuminate\Http\Request;

class BillController extends Controller
{
    public function index(Request $request)
    {
        $query = Bill::query()->with('user');
        $data = $query->get();
        return $this->success($data);
    }

    public function store(Request $request)
    {
        //form 验证
        $request->validate([
            'name' => 'required|min:3|max:33',
            'description' => 'max:200',
        ]);
        Bill::query()->create([
            'name' => $request->name,
            'description' => $request->description,
            'icon' => $request->icon,
            'parent_id' => $request->parent_id ?? 0,
            'creator' => auth()->user()->id,
        ]);
        return $this->success('成功');
    }
}
