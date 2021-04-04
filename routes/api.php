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

Route::group(['prefix' => 'auth'], function () {
    Route::post('login', 'Api\AuthController@login')->name('login');
    Route::post('signup', 'Api\AuthController@signUp')->name('signup');

    Route::group(['middleware' => ['api']], function () {
        Route::get('logout', 'Api\AuthController@logout')->name('logout');
    });
});

Route::group(['prefix' => 'product', 'middleware' => ['auth:api']], function () {
    Route::post('/listProducts', 'StoreController@getListProducts');
    Route::get('/product/{id}', 'StoreController@getProduct');
});

Route::group(['prefix' => 'order', 'middleware' => ['auth:api']], function () {
    Route::post('/newOrder', 'OrderController@newOrder');
    Route::post('/informationOrder', 'OrderController@informationOrder');
    Route::post('/listOrder', 'OrderController@listOrder');
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
