<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Board;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserBoardController extends Controller
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
    public function index($username)
    {
        $user = User::where('username', '=', $username)->first();
        if ($user->hasRole('user')) {
            return view('user.index')
                ->with('user', $user);
        } else if ($user->hasRole('superadministrator')) {
            return view('superadministrator.index')
                ->with('user', $user);
        } else {
            return redirect('/');
        }
    }

    public function new(){
        $user = User::where('username', '=', \Auth::user()->username)->first();
        return view('user.board.new')
            ->with('user', $user);
    }
    public function view($username,$boardName){
        $user = User::where('username', '=', $username)->first();
        $board = Board::with(['OwnerBoard'])
        ->where('user_id', '=', $user->id)
        ->where('name', '=', $boardName)
        ->get();
        return view('user.board.index')
            ->with('boardId', $board[0]->id);
    }
}
