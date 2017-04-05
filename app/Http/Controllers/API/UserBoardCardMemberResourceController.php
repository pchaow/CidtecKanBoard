<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\UserBoardController;
use App\Http\Requests\UserBoardRequest;
use App\Http\Requests\UserRequest;
use App\Models\Board;
use App\Models\Lane;
use App\Models\User;
use App\Models\BoardUser;
use App\Models\CardUser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserBoardCardMemberResourceController extends Controller
{

    public function index($userId, $boardId, $cardId)
    {

        $userInCard = CardUser::select('users_id')
        ->where('cards_id', $cardId)
        ->get();

        $userInBoard = BoardUser::select('users_id')
        ->where('boards_id', $boardId)
        ->whereNotIn('users_id', $userInCard)
        ->get();

        $user = User::whereIn('id', $userInBoard)->get();

        return $user;
    }

    public function store()
  {
        //
    }

    public function destroy()
    {
        //
    }
}
