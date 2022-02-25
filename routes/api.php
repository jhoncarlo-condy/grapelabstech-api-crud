<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\LoginController;
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

Route::get('login',[LoginController::class,'login']);

Route::middleware('jwt.auth')->resource('customers',CustomerController::class);

//test api for saloon
Route::get('customer_list',[CustomerController::class,'customer_list']);
Route::get('sample',[CustomerController::class,'sample']);
