<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SaloonController;
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


Route::prefix('admin')->group(function(){
    Route::post('/login',[LoginController::class,'login']);
    Route::post('/logout',[LoginController::class,'logout']);
    Route::get('/refresh',[LoginController::class,'refresh']);
});

Route::middleware('jwt.auth')->resource('customers',CustomerController::class);

//test api for saloon
Route::get('customer_list',[SaloonController::class,'customer_list']);
Route::get('view_customer_details',[SaloonController::class,'view_customer_details']);
Route::put('update_customer',[SaloonController::class,'update_customer']);
Route::post('add_customer',[SaloonController::class,'add_customer']);
Route::delete('delete_customer',[SaloonController::class,'delete_customer']);
