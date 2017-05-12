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
    if (auth()->user()) {
        return redirect('/' + auth()->user()->username);
    } else {
        return view('welcome');
    }

})->middleware('auth:api');

Route::get('/logout', function () {
    Auth::logout();
});

Auth::routes();

Route::group(['prefix' => 'superadministrator', 'middleware' => ['role:superadministrator']], function () {
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

Route::group(['prefix' => '{user}'], function () {
    Route::get('/', 'UserBoardController@index');
    Route::get('/close', 'UserBoardController@close');
    Route::get('/new', 'UserBoardController@create');
    Route::get('{boardName}', "UserBoardController@view");
    Route::get('{boardName}/edit', "UserBoardController@edit");
    Route::get('{boardName}/lanes', "UserBoardController@lanes");
    Route::get('{boardName}/members', "UserBoardController@members");
    Route::get('{boardName}/{laneName}/cards/new', "UserBoardCardController@create");
    Route::get('{boardName}/{laneName}/cards/{cardId}', "UserBoardCardController@view");
});
