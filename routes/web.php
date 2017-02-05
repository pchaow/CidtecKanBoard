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

Route::group(['prefix' => 'superadministrator','middleware' => ['role:superadministrator']], function () {
    Route::get('user', 'SuperAdministrator\\UserController@index');
    Route::get('user/create', "SuperAdministrator\\UserController@create");
    Route::get('user/{id}/edit', 'SuperAdministrator\\UserController@edit');


    Route::group(['prefix' => 'role'], function () {
        Route::get('/', "SuperAdministrator\\RoleController@index");
        Route::get('/create', "SuperAdministrator\\RoleController@create");
        Route::get('/{roleId}/edit/', "SuperAdministrator\\RoleController@edit");
    });

});

Route::post('/register/up', 'Auth\RegisterController@registerUP');
Route::get('home', 'HomeController@index');

Route::get('{user}', 'UserBoardController@index');
Route::get('{user}/new', 'UserBoardController@new');
Route::get('{user}/board/{boardName}', 'UserBoardController@view');
