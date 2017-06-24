<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserBoardController;
use App\Http\Requests\UserBoardRequest;
use App\Http\Requests\UserRequest;
use App\Models\ActivityLog;
use App\Models\Card;
use App\Models\CardUser;
use App\Models\Lane;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserBoardCardResourceController extends Controller
{

    public function show($userId, $boardId, $cardId)
    {
        $card = Card::with(['membersCard', 'ownerCard'])
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
        $card->rank = $cardCount + 1;
        $card->save();

        foreach ($request->members_card as $member) {
            $cardUser = new CardUser();
            $cardUser->cards_id = $card->id;
            $cardUser->users_id = $member['id'];
            $cardUser->save();
        }

        $this->Log(ActivityLog::ACTION_TYPE_ADD_CARD, [
            ActivityLog::LOG_BOARD_ID => $boardId,
            ActivityLog::LOG_CARD_ID => $card->id,
            ActivityLog::LOG_USER_ID => Auth::user()->id
        ]);

        return $request->all();
    }

    public function update(Request $request, $userId, $boardId, $cardId)
    {
        try {
            DB::beginTransaction();

            if (isset($request) && isset($userId) && isset($boardId) && isset($cardId)) {
                if (count($request->all()) !== 3) {
                    /** @var Card $card */
                    $card = Card::where('id', $cardId)
                        ->where('user_id', $userId)
                        ->first();
                    $card->fill($request->all());
                    $card->save();
                    CardUser::where('cards_id', $cardId)
                        ->delete();
                    foreach ($request->members_card as $member) {
                        $cardUser = new CardUser();
                        $cardUser->cards_id = $card->id;
                        $cardUser->users_id = $member['id'];
                        $cardUser->save();
                    }

                    /** @var Lane $lane */
                    $lane = $card->lane->board;
                    $board_id = $lane->id;
                    $this->Log(ActivityLog::ACTION_TYPE_EDIT_CARD, [
                        ActivityLog::LOG_BOARD_ID => $board_id,
                        ActivityLog::LOG_CARD_ID => $card->id,
                        ActivityLog::LOG_USER_ID => Auth::user()->id
                    ]);

                } else {
                    /** @var Card $card */
                    $card = Card::where('id', $cardId)
                        ->where('user_id', $userId)
                        ->first();
                    $card->fill($request[0]);
                    $card->save();

                    foreach ($request[1] as $before) {
                        /** @var Card $cardBefore */
                        $cardBefore = Card::where('id', $before['id'])
                            ->where('lanes_id', $before['lane'])
                            ->first();
                        $cardBefore->rank = $before['rank'];
                        $cardBefore->save();
                    }

                    foreach ($request[2] as $after) {
                        /** @var Card $cardAfter */
                        $cardAfter = Card::where('id', $after['id'])
                            ->where('lanes_id', $after['lane'])
                            ->first();
                        $cardAfter->rank = $after['rank'];
                        $cardAfter->save();
                    }

                    /** @var Lane $lane */
                    $lane = $card->lane->board;
                    $board_id = $lane->id;
                    $this->Log(ActivityLog::ACTION_TYPE_MOVE_CARD, [
                        ActivityLog::LOG_BOARD_ID => $board_id,
                        ActivityLog::LOG_CARD_ID => $card->id,
                        ActivityLog::LOG_LANE_ID => $card->lane->id,
                        ActivityLog::LOG_USER_ID => Auth::user()->id
                    ]);
                }
            }

            DB::commit();

            return response([
                'success' => true,
                'message' => Auth::user()->name . ' moved ' . $card->name . ' to ' . $card->lane->name,
            ]);

        } catch (\Exception $e) {

            DB::rollBack();

            return response([
                'message' => $e->getMessage(),
                'trace' => $e->getTrace(),
                'line' => $e->getLine()
            ]);
        }

    }

    public function destroy($userId, $boardId, $cardId)
    {

        try {
            DB::beginTransaction();

            /** @var Card $card */
            $card = Card::with(['membersCard'])
                ->where('id', $cardId)
                ->where('user_id', $userId)
                ->first();

            $board = $card->lane->board;

            $this->Log(ActivityLog::ACTION_TYPE_DELETE_CARD, [
                ActivityLog::LOG_BOARD_ID => $boardId,
                ActivityLog::LOG_CARD_ID => $cardId,
                ActivityLog::LOG_USER_ID => Auth::user()->id
            ]);

            DB::commit();

            return $board;

        } catch (\Exception $e) {

            DB::rollBack();

            return response([
                'message' => $e->getMessage(),
                'trace' => $e->getTrace(),
                'line' => $e->getLine()
            ]);
        }

    }
}
