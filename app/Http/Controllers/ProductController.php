<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductCollection;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiBaseController as Controller;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();
        if ($search = $request->search) {

        }
        $perPage = $request->perPage ?? 10;
        $data = $query->paginate($perPage);
        return $this->success(new ProductCollection($data));
    }
}
