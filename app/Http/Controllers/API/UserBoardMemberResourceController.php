<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\UserBoardController;
use App\Http\Requests\UserBoardRequest;
use App\Http\Requests\UserRequest;
use App\Models\Board;
use App\Models\Lane;
use App\Models\User;
use App\Models\BoardUser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserBoardMemberResourceController extends Controller
{

    public function index($userId, $boardId)
    {
        $userIn = BoardUser::select('users_id')
        ->where('boards_id',$boardId)
        ->get();
        $user = User::whereNotIn('id', $userIn)->get();;
        return $user;
    }

    public function store(Request $request, $userId, $boardId)
  {
        $boardUser = new BoardUser();
        $boardUser->boards_id = $boardId;
        $boardUser->users_id = $request->id;
        $boardUser->save();
        return $boardUser;
    }

    public function destroy()
    {
        // $lane = Lane::find($laneId);
        // $lane->delete();
        return [true];
    }
}
