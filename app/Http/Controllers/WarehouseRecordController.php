<?php

namespace App\Http\Controllers;

use App\Http\Resources\WarehouseCollection;
use App\Models\StorehouseRecord;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiBaseController as Controller;

class WarehouseRecordController extends Controller
{
    public function index(Request $request)
    {
        $query = StorehouseRecord::query();
        if ($search = $request->search) {

        }
        $perPage = $request->perPage ?? 10;

        $data = $query->paginate($perPage);
        return $this->success(new WarehouseCollection($data));
    }
}
