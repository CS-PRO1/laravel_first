<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\ThirdController;
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



Route::prefix('products')->group(function () {
    Route::get('', 'ProductController@ListAllProducts');
    Route::post('', 'ProductController@CreateProduct');
    Route::post('/{productid}', 'ProductController@UpdateProductByID');
    Route::delete('/{productid}', 'ProductController@DeleteProductByID');
});





Route::prefix ('members')->group(function() {
    Route::get('', 'ThirdController@index');
    Route::post('', 'ThirdController@store');
    Route::post('', 'ThirdController@show');
    Route::put('{id}', 'ThirdController@update');
    Route::delete('{id}', 'ThirdController@destroy');
});

Route::get('check_id', 'FourthController@check')->middleware(['check_token']);
Route::get('login', 'FourthController@login')->middleware(['login']);
Route::get('product_delete', 'FourthController@destroy')->middleware(['ownership_check']);
