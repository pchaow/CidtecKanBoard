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

Route::get('/user', function (Request $request) {
    return \App\Models\User::all();
})->middleware('auth:api');

Route::group(["prefix" => 'v1/admin'], function () {

    Route::resource('user', "API\\UserResourceController");
    Route::resource('role', "Api\\RoleResourceController");

});

Route::group(["prefix" => 'v1/board'], function () {

    Route::post('new',function(Request $request){
        return \Auth::user();
        return $request->all();

    })->middleware('auth:api');
});
