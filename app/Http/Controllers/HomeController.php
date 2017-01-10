<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Lane;
use App\Models\Board;
use App\Models\Card;
use App\Models\BoardUser;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
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
        $user = Auth::user();

        return redirect("/$user->username");
    }

    public function getBoards()
    {
        $data = Board::all();
        return $data;
    }

    public function getLanes()
    {
        $data = Lane::all();
        return $data;
    }

    public function getCards()
    {
        $data = Card::all();
        return $data;
    }
    public function getBoardUser($id)
    {
       $data = Permission::with(['roles'])
         ->where('name','=','profile-read')
        ->get();
        return $data;
    }

    public function user($username)
    {
        $user = User::where('username', '=', $username)->first();
        if ($user) {
            return view('home')
                ->with('user', $user);
        } else {
            return redirect('/');
        }

    }
}
