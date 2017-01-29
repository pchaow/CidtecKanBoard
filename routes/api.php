<?php

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Board;

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

        return $request->all();
    })->middleware('auth:api');

    Route::get('all',function(Request $request){
      $id = \Auth::user()->id;
      $boards = Board::where('user_id', '=', $id)->get();
      $boards = Board::all();

        return $boards;
    })->middleware('auth:api');

});
