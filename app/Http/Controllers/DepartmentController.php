<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiBaseController as Controller;
use Illuminate\Support\Facades\DB;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = Department::query();
        $data = $query->get();
        return $this->success($data);
    }

    public function list()
    {
        $data = $this->handle();
        return $this->success($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (is_array($id = $request->parent_id)) {
            $parent_id = array_pop($id);
        } else {
            $parent_id = $request->parent_id;
        }


        if ($parent_id == 0) {
            $path = '-0-';
        } else {
            $father = Department::query()->findOrFail($parent_id);
            $path = $father->path . $father->id . '-';
        }

        Department::query()->create([
            'name' => $request->name,
            'parent_id' => $parent_id,
            'path' => $path,
            'remark' => $request->remark,
        ]);
        return $this->success($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {


        if (is_array($id = $request->parent_id)) {
            $parent_id = array_pop($id);
        } else {
            $parent_id = $request->parent_id;
        }


        if ($parent_id == 0) {
            $path = '-0-';
        } else {
            $father = Department::query()->findOrFail($parent_id);
            $path = $father->path . $father->id . '-';
        }

        $update = [
            'name' => $request->name,
            'parent_id' => $parent_id,
            'path' => $path,
            'remark' => $request->remark,
        ];
//        return $this->success($update);
        Department::query()->where('id', $request->id)->update($update);

        return $this->success('success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Department::query()->where('id', $id)->delete();
        return  $this->success('success');
    }

    public function handle($parentId = 0)
    {
        $data = Department::query()->where('parent_id', $parentId)->get([DB::raw('id as value'), DB::raw('name as label'), 'parent_id'])->toArray();

        foreach ($data as $k => $item) {

            $item['children'] = $this->handle($item['value']);
            $data[$k] = $item;

        }
        return $data;
    }
}
