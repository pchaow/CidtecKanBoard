<?php

namespace App\Http\Controllers\SuperAdministrator;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function index()
    {
        return view('superadministrator.user.index');
    }

    public function create()
    {
        return view('superadministrator.user.create');

    }

    public function edit($userId)
    {
        return view('superadministrator.user.edit')
            ->with('userId', $userId);

    }
}
