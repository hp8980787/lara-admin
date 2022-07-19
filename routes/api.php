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

    $router->middleware('auth:sanctum')->group(function (\Illuminate\Routing\Router $router){
        $router->delete('user/logout', [\App\Http\Controllers\UserController::class, 'logout']);
        $router->get('user/info', [\App\Http\Controllers\UserController::class, 'info']);
        $router->post('user/assign_role', [\App\Http\Controllers\UserController::class, 'assignRole']);
        $router->get('users/list', [\App\Http\Controllers\UserController::class, 'list']);
        $router->resource('roles', \App\Http\Controllers\RoleController::class)->except('create')->parameter('roles', 'id');
        $router->resource('orders', \App\Http\Controllers\OrderController::class)->parameter('orders', 'id')->except('create');
        $router->post('orders/link_products', [\App\Http\Controllers\OrderController::class, 'linkProducts']);
        $router->resource('supplier', \App\Http\Controllers\SupplierController::class)->parameter('supplier', 'id');
        $router->resource('purchases', \App\Http\Controllers\PurchaseController::class)->parameter('purchases', 'id');
        $router->resource('warehouses', \App\Http\Controllers\StorehouseController::class)->except('edit', 'show')->parameter('warehouses', 'id');
        $router->resource('products', \App\Http\Controllers\ProductController::class)->except('edit', 'show')->parameter('products', 'id');
        $router->get('rate', [\App\Http\Controllers\RateController::class, 'rate']);
    });

    $router->post('user/login', [\App\Http\Controllers\UserController::class, 'login']);
    $router->post('user/register', [\App\Http\Controllers\UserController::class, 'register']);


});

