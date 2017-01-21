<?php

namespace App\Http\Controllers\SuperAdministrator;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class RoleController extends Controller
{
    public function index()
    {
        return view('superadministrator.role.index');
    }

    public function create()
    {
        return view('superadministrator.role.create');

    }

    public function edit($roleId)
    {
        return view('superadministrator.role.edit')
            ->with('roleId', $roleId);

    }
}
