<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PartyController;
use App\Http\Controllers\ShopsController;
use App\Http\Controllers\ProductController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Auth routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::post('/create-shop', [ShopsController::class, 'store'])->middleware('auth:sanctum');


//Routes for authenticated users to CRUD parties
Route::middleware(['auth:sanctum'])->group(function () {
    Route::prefix('/shop/{shop_id}')->group(function () {
        Route::resource('/parties', PartyController::class);
        Route::resource('/products', ProductController::class);
        Route::resource('/products-category', ProductController::class);
    });

});
