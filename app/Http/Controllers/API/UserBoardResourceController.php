<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\UserBoardController;
use App\Http\Requests\UserBoardRequest;
use App\Http\Requests\UserRequest;
use App\Models\Board;
use App\Models\BoardStatus;
use App\Models\Lane;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserBoardResourceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $userId)
    {
        $user = User::find($userId);

        $query = $user->boardsIn();

        $query->with(['user'])
            ->whereHas('membersBoard',
                function ($query) use ($userId) {
                    $query->where('users_id', '=', $userId);
                })
            ->orderBy('id', 'desc');

        if ($request->has('close') || $request->get('close') == 'true') {
            $query->where('board_status_id', '=', 2);
        }else {
            $query->where('board_status_id', '=', 1);
        }
        $board = $query->get();
        return $board;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserBoardRequest $request, $userId)
    {
        $currentUser = User::find($userId);
        $board = new Board();
        $board->board_status_id = 1;
        $board->fill($request->all());
        $board->user()->associate($currentUser);
        $board->save();

        $defaultLane = ['สิ่งที่ต้องทำ', 'กำลังทำ', 'เสร็จแล้ว'];

        foreach ($defaultLane as $item) {
            $lane = new Lane();
            $lane->name = $item;
            $board->lanes()->save($lane);
        }

        $board->membersBoard()->save($currentUser);

        return $board;
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($userId, $boardId)
    {
        $board = Board::with(['user', 'lanes.cards', 'lanes.cards.membersCard', 'membersBoard'])->where('id', $boardId)->first();
        return $board;

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $userId, $boardId)
    {
        $board = Board::with(['user', 'lanes'])->where('id', $boardId)->first();
        $board->fill($request->all());
        $board->save();
        $boardForm = $request->all();

        foreach ($boardForm['lanes'] as $laneForm) {
            if (isset($laneForm['id'])) {
                $lane = Lane::find($laneForm['id']);
                $lane->name = $laneForm['name'];
                $lane->save();
            } else {
                $lane = new Lane();
                $lane->fill($laneForm);
                $board->lanes()->save($lane);
            }
        }

        return $board;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, $bid)
    {
        // $board Board;
        $board = Board::find($bid);
        $status = BoardStatus::where('name', 'close')->first();
        $board->boardStatus()->associate($status->id);
        $board->save();

        return $board;

    }
}
