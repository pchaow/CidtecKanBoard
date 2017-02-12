<?php

namespace App\Http\Controllers\API;

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
        return $user->boards()->get();
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
    public function store(Request $request, $userId)
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
        $board = Board::with(['user', 'lanes'])->where('id', $boardId)->first();
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
    public function update(Request $request, $id)
    {

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
