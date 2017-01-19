<?php

namespace App\Http\Controllers\SuperAdministrator;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class RoleController extends Controller
{
    public function index()
    {
        return view('admin.role.index');
    }

    public function create()
    {
        return view('admin.role.create');

    }

    public function edit($roleId)
    {
        return view('admin.role.edit')
            ->with('roleId', $roleId);

    }
}
