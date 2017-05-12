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
        $user = User::findByUsername($username);

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

    public function create($username)
    {
        $user = User::findByUsername($username);
        return view('user.board.new')
            ->with('user', $user);
    }

    public function view($username, $boardName)
    {
        $user = User::findByUsername($username);

        $board = Board::with(['user'])
            ->where('user_id', '=', $user->id)
            ->where('name', '=', $boardName)
            ->first();
        return view('user.board.index')
            ->with('board', $board)
            ->with('user', $user);
    }

    public function edit($username, $boardName)
    {
        $user = User::findByUsername($username);

        $board = Board::with(['user'])
            ->where('user_id', '=', $user->id)
            ->where('name', '=', $boardName)
            ->first();

        return view('user.board.edit')
            ->with('board', $board)
            ->with('user', $user);
    }

    public function lanes($username, $boardName)
    {
        $user = User::findByUsername($username);

        $board = Board::with(['user'])
            ->where('user_id', '=', $user->id)
            ->where('name', '=', $boardName)
            ->first();

        return view('user.board.lanes')
            ->with('board', $board)
            ->with('user', $user);
    }

    public function members($username, $boardName)
    {
        $user = User::findByUsername($username);

        $board = Board::with(['user'])
            ->where('user_id', '=', $user->id)
            ->where('name', '=', $boardName)
            ->first();

        return view('user.board.members')
            ->with('board', $board)
            ->with('user', $user);
    }
}
