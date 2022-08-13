<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::prefix('v1')->group(function (\Illuminate\Routing\Router $router) {

    $router->middleware('auth:sanctum')->group(function (\Illuminate\Routing\Router $router) {
        $router->delete('user/logout', [\App\Http\Controllers\UserController::class, 'logout']);
        $router->get('user/info', [\App\Http\Controllers\UserController::class, 'info']);
        $router->post('user/assign_role', [\App\Http\Controllers\UserController::class, 'assignRole']);
        $router->get('users/list', [\App\Http\Controllers\UserController::class, 'list']);
        $router->resource('roles', \App\Http\Controllers\RoleController::class)->except('create')->parameter('roles', 'id');
        $router->resource('orders', \App\Http\Controllers\OrderController::class)->parameter('orders', 'id')->except('create');
        $router->post('orders/link_products', [\App\Http\Controllers\OrderController::class, 'linkProducts']);
        $router->post('orders/ship', [\App\Http\Controllers\OrderController::class, 'ship']);
        $router->post('orders/warehouse', [\App\Http\Controllers\OrderController::class, 'warehouse']);
        $router->resource('supplier', \App\Http\Controllers\SupplierController::class)->parameter('supplier', 'id');
        $router->resource('purchases', \App\Http\Controllers\PurchaseController::class)->parameter('purchases', 'id');
        $router->put('purchases/{id}/approve', [\App\Http\Controllers\PurchaseController::class, 'approve']);
        $router->resource('warehouses', \App\Http\Controllers\StorehouseController::class)->except('edit', 'show')->parameter('warehouses', 'id');
        $router->get('warehouses/list', [\App\Http\Controllers\StorehouseController::class, 'list']);
        $router->resource('warehouses/record', \App\Http\Controllers\WarehouseRecordController::class)->only('index', 'destroy')->parameter('record', 'id');
        $router->resource('products', \App\Http\Controllers\ProductController::class)->except('edit', 'show')->parameter('products', 'id');
        $router->resource('departments', \App\Http\Controllers\DepartmentController::class)->except('edit', 'show')->parameter('departments', 'id');
        $router->get('departments/list', [\App\Http\Controllers\DepartmentController::class, 'list']);
        $router->get('rate', [\App\Http\Controllers\RateController::class, 'rate']);
        //账单api
        Route::prefix('bill')->group(function (\Illuminate\Routing\Router $router) {
            //账单分类
            $router->resource('category', \App\Http\Controllers\Bill\BillCategoryController::class)->except('show', 'edit')->parameter('category', 'id');
            //账本
            $router->resource('/', \App\Http\Controllers\Bill\BillController::class)->except('show', 'edit')->parameter('', 'id');
            //账本字段
            $router->resource('columns',\App\Http\Controllers\Bill\ColumnController::class)->except('show','edit')->parameter('columns','id');
        });
    });

    $router->post('user/login', [\App\Http\Controllers\UserController::class, 'login']);
    $router->post('user/register', [\App\Http\Controllers\UserController::class, 'register']);


});

