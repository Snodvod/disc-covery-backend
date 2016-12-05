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


Route::group(['prefix' => 'messages'], function () {
	Route::get('/', 'MessageController@index');
});

Route::group(['prefix' => 'records'], function () {
	Route::get('/', 'RecordController@index');

});

Route::group(['prefix' => 'users'], function () {
	Route::get('/', 'UserController@index');

});

Route::group(['prefix' => 'subscriptions'], function () {
	Route::get('/', 'UserController@subscriptions');

});