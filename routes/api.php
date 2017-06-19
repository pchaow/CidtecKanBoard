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

Route::group(["prefix" => 'v1','middleware'=>'auth:api'], function () {

    Route::resource('user.board', "API\\UserBoardResourceController");

    Route::resource('user.board.lane', "API\\UserBoardLaneResourceController");
    Route::resource('user.board.card', "API\\UserBoardCardResourceController");
    Route::resource('user.board.card.member', "API\\UserBoardCardMemberResourceController");
    Route::resource('user.board.member', "API\\UserBoardMemberResourceController");

});
