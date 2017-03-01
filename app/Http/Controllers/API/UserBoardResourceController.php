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
        $board = $user->boards()
                ->with(['user'])
                ->orWhereHas ('membersBoard',
                      function ($query) use ( $userId ) {
                            $query->where('users_id', '=', $userId );
                      })
                ->orderBy('id', 'desc')
                ->get();
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
        $board = new Board();
        $board->fill($request->all());
        $board->user()->associate($userId);
        $board->save();

        $defaultLane = ['Todo', 'Doing', 'Done'];

        foreach ($defaultLane as $item) {
            $lane = new Lane();
            $lane->name = $item;
            $board->lanes()->save($lane);
        }
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
    public function destroy($id)
    {

    }
}
