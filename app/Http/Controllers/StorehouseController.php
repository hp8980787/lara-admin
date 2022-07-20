<?php

namespace App\Http\Controllers;

use App\Http\Resources\StorehouseCollection;
use App\Models\Storehouse;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiBaseController as Controller;

class StorehouseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Storehouse::query()->with('stocks');
        if ($search = $request->search) {

        }
        $perPage = $request->perPage ?? 10;
        $data = $query->paginate($perPage);

        return $this->success(new StorehouseCollection($data));
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
        Storehouse::query()->create([
            'name' => $request->name
        ]);

        return $this->success('成功');
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
        Storehouse::query()->where('id',$id)->update([
            'name'=>$request->name
        ]);
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
        Storehouse::query()->where('id',$id)->delete();
        return  $this->success('成功');
    }

    public function list()
    {
        $query = Storehouse::query();
        $data = $query->get();
        return $this->success($data);
    }
}
