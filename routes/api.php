<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\AuthController;
use App\Http\Controllers\Dashboard\InvoiceController;
use App\Http\Controllers\Dashboard\ProductController;
use App\Http\Controllers\Dashboard\CategoryControllery;

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
// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::post('login', [AuthController::class,'login']);

Route::resource('product', ProductController::class);

Route::resource('invoice', InvoiceController::class);

Route::middleware(['auth:api'])->group(function () {
    Route::get('user_detail', [AuthController::class,'getUserDetail']);
    Route::get('logout', [AuthController::class,'logout']);

    Route::resource('category', CategoryControllery::class);

    Route::get('invoice/details/{id}', [InvoiceController::class,'showDetails']);

});
