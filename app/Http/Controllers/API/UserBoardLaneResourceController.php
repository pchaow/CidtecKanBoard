<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\UserBoardController;
use App\Http\Requests\UserBoardRequest;
use App\Http\Requests\UserRequest;
use App\Models\Board;
use App\Models\Lane;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserBoardLaneResourceController extends Controller
{

    public function store(Request $request, $userId, $boardId)
    {
        $board = Board::find($boardId);

        $lane = new Lane();
        $lane->fill($request->all());
        $board->lanes()->save($lane);

        return $lane;
    }

    public function destroy($userId, $boardId, $laneId)
    {
        $lane = Lane::find($laneId);
        $lane->delete();
        return [true];
    }
}
