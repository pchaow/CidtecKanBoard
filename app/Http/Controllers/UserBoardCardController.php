<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Board;
use App\Models\Card;
use App\Models\Lane;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserBoardCardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
      //
    }

    public function create($username,$boardName,$laneName)
    {
      $user = User::findByUsername($username);

      $board = Board::with(['user'])
          ->where('user_id', '=', $user->id)
          ->where('name', '=', $boardName)
          ->first();

      $lane = Lane::where('board_id', '=', $board->id)
          ->where('name', '=', $laneName)
          ->first();

      return view('user.card.new')
          ->with('board', $board)
          ->with('lane', $lane)
          ->with('user', $user);
    }

    public function view()
    {
        //
    }

    public function edit()
    {
      //
    }
}
