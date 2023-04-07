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

Route::post('/register', [App\Http\Controllers\API\AuthController::class, 'register']);
Route::post('/login', [App\Http\Controllers\API\AuthController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/order', [App\Http\Controllers\API\OrderController::class, 'store']);
    Route::get('/order/{order_id}', [App\Http\Controllers\API\OrderController::class, 'orderTracks']);
    Route::get('/order/detail/{order_id}', [App\Http\Controllers\API\OrderController::class, 'orderDetail']);
});
