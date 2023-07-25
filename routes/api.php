<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\SaleDetailController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\InfoController;
use App\Http\Middleware\Authenticate;
use App\Http\Middleware\CheckProfileId;
use App\Http\Middleware\CheckIsActive;



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
Route::middleware(Authenticate::class, CheckProfileId::class, CheckIsActive::class)->resource('users', UserController::class);
Route::middleware(Authenticate::class, CheckProfileId::class, CheckIsActive::class)->resource('profiles', ProfileController::class);


Route::get('products', 'App\Http\Controllers\ProductController@index');
Route::get('products/{id}', 'App\Http\Controllers\ProductController@show');
Route::get('products/search/{text}', 'App\Http\Controllers\ProductController@search');

Route::middleware(Authenticate::class, CheckProfileId::class, CheckIsActive::class)->post('products', 'App\Http\Controllers\ProductController@store');
Route::middleware(Authenticate::class, CheckProfileId::class, CheckIsActive::class)->put('products/{id}', 'App\Http\Controllers\ProductController@update');
Route::middleware(Authenticate::class, CheckProfileId::class, CheckIsActive::class)->delete('products/{id}', 'App\Http\Controllers\ProductController@destroy');

Route::get('categories', 'App\Http\Controllers\CategoryController@index');
Route::get('categories/{id}', 'App\Http\Controllers\CategoryController@show');
Route::get('categories/with/products', 'App\Http\Controllers\CategoryController@listAllWithProducts');

Route::middleware(Authenticate::class, CheckProfileId::class, CheckIsActive::class)->post('categories', 'App\Http\Controllers\CategoryController@store');
Route::middleware(Authenticate::class, CheckProfileId::class, CheckIsActive::class)->put('categories/{id}', 'App\Http\Controllers\CategoryController@update');
Route::middleware(Authenticate::class, CheckProfileId::class, CheckIsActive::class)->delete('categories/{id}', 'App\Http\Controllers\CategoryController@destroy');


Route::middleware(Authenticate::class)->resource('sales', SaleController::class);
Route::middleware(Authenticate::class)->resource('saledetails', SaleDetailController::class);

Route::middleware(Authenticate::class, CheckProfileId::class, CheckIsActive::class)->get('data/balance', 'App\Http\Controllers\InfoController@getBalance');
Route::middleware(Authenticate::class, CheckProfileId::class, CheckIsActive::class)->get('data/balance/sale', 'App\Http\Controllers\InfoController@getBalanceSaleToday');
Route::middleware(Authenticate::class, CheckProfileId::class, CheckIsActive::class)->get('data/sales/week', 'App\Http\Controllers\InfoController@getNumberSalesWeek');
Route::middleware(Authenticate::class, CheckProfileId::class, CheckIsActive::class)->get('data/products/moresales', 'App\Http\Controllers\InfoController@getMoreSalesProducts');
Route::middleware(Authenticate::class, CheckProfileId::class, CheckIsActive::class)->get('data/latestusers', 'App\Http\Controllers\InfoController@getLatestUsers');








Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('login', 'App\Http\Controllers\AuthController@login');
    Route::post('logout', 'App\Http\Controllers\AuthController@logout');
    Route::post('refresh', 'App\Http\Controllers\AuthController@refresh');
    Route::post('me', 'App\Http\Controllers\AuthController@me');
    Route::post('register', 'App\Http\Controllers\AuthController@register');
});
