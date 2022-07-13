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

    $router->post('user/login', [\App\Http\Controllers\UserController::class, 'login']);
    $router->post('user/register', [\App\Http\Controllers\UserController::class, 'register']);
    $router->delete('user/logout', [\App\Http\Controllers\UserController::class, 'logout']);
    $router->get('user/info', [\App\Http\Controllers\UserController::class, 'info']);
    $router->post('user/assign_role',[\App\Http\Controllers\UserController::class,'assignRole']);
    $router->get('users/list', [\App\Http\Controllers\UserController::class, 'list']);

    $router->resource('roles',\App\Http\Controllers\RoleController::class)->except('create')->parameter('roles','id');
});

