<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'soda'], function () {
    Route::post('create', 'SodaController@create');
    Route::put('update/{id}', 'SodaController@update');
    Route::get('/', 'SodaController@getAll');
    Route::get('/{id}', 'SodaController@get');
    Route::delete('/{json}/delete', 'SodaController@delete');
});
