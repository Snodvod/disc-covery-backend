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

Route::get('/following', 'UserController@following');
Route::get('/followed-by', 'UserController@followedBy');
Route::get('/my-music', 'RecordController@myList');
Route::get('/newsfeed', 'MessageController@get');

Route::group(['prefix' => 'messages'], function () {
 	Route::get('/', 'MessageController@index');
 });

Route::group(['prefix' => 'records'], function () {
 	Route::get('/add/{record_id}', 'RecordController@findOwner');
    Route::get('/find', 'RecordController@find');
    Route::get('/{id}/get', 'RecordController@show');
 });

Route::group(['prefix' => 'users'], function () {
     Route::get('/find', 'UserController@search');
     Route::get('/find-by-record/{record_id}', 'RecordController@findOwner');
     Route::get('/{id}/get', 'UserController@show');

     Route::post('/{id}/save', 'UserController@update');

     Route::delete('/delete', 'UserController@destroy');
 });

 Route::group(['prefix' => 'subscriptions'], function () {
 	Route::get('/', 'UserController@subscriptions');
 });

Route::post('test', 'RecordController@find');

Route::post('register', 'UserController@create');