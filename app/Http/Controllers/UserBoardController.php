<?php

namespace App\Http\Controllers;

use App\Models\User;
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
        if ($user) {
            return view('user.index')
                ->with('user', $user);
        } else {
            return redirect('/');
        }
    }
}
