<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\ThirdController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/check_user', 'FirstController@checkUserName');

Route::get('/add_users', 'SecondController@addUsers');
Route::get('/check_info', 'SecondController@checkInfo');






