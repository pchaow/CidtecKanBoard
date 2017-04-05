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

  public function show($userId, $boardId, $cardId)
  {
      $card = Card::with(['membersCard','ownerCard'])
              ->where('id', $cardId)
              ->first();
      return $card;

  }

    public function store(Request $request, $userId, $boardId)
    {
        $cardCount = Card::where('lanes_id', $request->lanes_id)
        ->count();
        $card = new Card();
        $card->fill($request->all());
        $card->rank = $cardCount+1;
        $card->save();

        foreach ($request->members_card as $member) {
          $cardUser = new CardUser();
          $cardUser->cards_id = $card->id;
          $cardUser->users_id = $member['id'];
          $cardUser->save();
        }

        return $request->all();
    }

    public function update(Request $request, $userId, $boardId, $cardId)
    {
        if (count($request->all()) !== 3) {
          $card = Card::where('id', $cardId)
                  ->where('user_id', $userId)
                  ->first();
          $card->fill($request->all());
          $card->save();
          $delCardUser = CardUser::where('cards_id',$cardId)
                      ->delete();
          foreach ($request->members_card as $member) {
                   $cardUser = new CardUser();
                   $cardUser->cards_id = $card->id;
                   $cardUser->users_id = $member['id'];
                   $cardUser->save();
                }

        }else {

          $card = Card::where('id', $cardId)
                  ->where('user_id', $userId)
                  ->first();
          $card->fill($request[0]);
          $card->save();

          foreach ($request[1] as $before) {
                   $cardBefore = Card::where('id', $before['id'])
                   ->where('lanes_id', $before['lane'])
                   ->first();
                   $cardBefore->rank = $before['rank'];
                   $cardBefore->save();
                }

          foreach ($request[2] as $after) {
                  $cardAfter = Card::where('id', $after['id'])
                  ->where('lanes_id', $after['lane'])
                  ->first();
                  $cardAfter->rank = $after['rank'];
                  $cardAfter->save();
               }
        }

        return $request->all();
    }

    public function destroy($userId, $boardId, $cardId)
    {

      $card = Card::with(['membersCard'])
            ->where('id', $cardId)
            ->where('user_id', $userId)
            ->delete();
        return $card;
    }
}
