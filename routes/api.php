<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
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


Route::middleware('auth:api')->group(function () {
    Route::get('orders/export/csv', [OrderController::class, 'exportToCSV']);
    Route::apiResources([
        'users' => UserController::class,
        'roles' => RoleController::class,
        'products' => ProductController::class,
        'orders' => OrderController::class
    ]);
    Route::post('products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::get('me', [UserController::class, 'me']);
    Route::put('update-info', [UserController::class, 'updateInfoCurrentUser']);
});

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);
