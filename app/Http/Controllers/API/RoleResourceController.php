<?php

namespace App\Http\Controllers\Api;

use App\Models\Role;
use Illuminate\Http\Request;

use App\Http\Requests\RoleRequest;
use App\Http\Controllers\Controller;

class RoleResourceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Role::query();

        if ($request->has('keyword')) {
            $keyword = $request->get('keyword');
            $query->orWhere('name', 'LIKE', "%$keyword%");
            $query->orWhere('description', 'LIKE', "%$keyword%");

        }

        return $query->paginate();

    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleRequest $request)
    {
        $form = $request->all();
        $role = new Role();
        $role->fill($form);

        $role->save();
        return $role;
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $role = Role::find($id);
        return $role;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(RoleRequest $request, $id)
    {
        $form = $request->all();
        $role = Role::find($id);
        $role->fill($form);

        $role->save();
        return $role;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(RoleRequest $request, $id)
    {
        $role = Role::find($id);
        $role->delete();
        return [true];
    }
}
