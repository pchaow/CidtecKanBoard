<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::group(['prefix'=>'superadministrator'], function () {
    Route::get('user', 'SuperAdministrator\UserController@index');
});

Route::post('/register/up', 'Auth\RegisterController@registerUP');
Route::get('home', 'HomeController@index');
Route::get('{user}', 'UserBoardController@index');
