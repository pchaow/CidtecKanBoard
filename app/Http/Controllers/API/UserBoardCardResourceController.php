<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\UserBoardController;
use App\Http\Requests\UserBoardRequest;
use App\Http\Requests\UserRequest;
use App\Models\Card;
use App\Models\CardUser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserBoardCardResourceController extends Controller
{

    public function store(Request $request, $userId, $boardId)
    {

        $card = new Card();
        $card->fill($request->all());
        $card->save();

        foreach ($request->memberCard as $member) {
          $cardUser = new CardUser();
          $cardUser->cards_id = $card->id;
          $cardUser->users_id = $member['id'];
          $cardUser->save();
        }

        return $request->all();
    }

    public function update(Request $request, $userId, $boardId,$cardId)
    {
        $card = Card::find($cardId);
        $card->fill($request->all());
        $card->save();
        return $card;
    }

    public function destroy($userId, $boardId, $laneId)
    {
        $lane = Lane::find($laneId);
        $lane->delete();
        return [true];
    }
}
