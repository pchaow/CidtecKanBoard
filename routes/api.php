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

  Route::resource('view', "API\\BoardResourceController");

    Route::post('new',function(Request $request){

         $request->merge(array('user_id' => \Auth::user()->id));

         $form = $request->all();
         $board = new Board();
         $board->fill($form);
         $board->save();
         return $board;

    })->middleware('auth:api');


    Route::get('index',function(Request $request){
        $id = \Auth::user()->id;
        $boards = Board::with(['OwnerBoard'])
        ->where('user_id', '=', $id)
        ->orderBy('id', 'desc')
        ->get();
        return $boards;
    })->middleware('auth:api');

});
