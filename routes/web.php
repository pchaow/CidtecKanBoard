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
Route::post('/register/up', 'Auth\RegisterController@registerUP');

Route::get('/getLanes', 'HomeController@getLanes');
Route::get('/getBoards', 'HomeController@getBoards');
Route::get('/getCards', 'HomeController@getCards');
Route::get('/getBoardUser/{id}', 'HomeController@getBoardUser');

Route::get('/home', 'HomeController@index');
Route::get('/{user}', 'UserBoardController@index');
