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
Route::group(['prefix' => 'reports'], function () {
    Route::get('admin-today','Api\ApiController@admin_today');
    Route::get('user-wise-transaction','Api\ApiController@user_trans');
    Route::get('cash-flow','Api\ApiController@cashFlow');
});