<?php

namespace App\Http\Controllers\Admin;

use App\Role;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RoleUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, User $user)
    {
        $field = 'id';
        $paginate = '20';
        $sort_type = 'ASC';
        $roles_only = false;
        if (Request()->ajax()) {
            if ($request->sort_by != '') {
                $field = $request->sort_by;
                if ($field == 'priority')
                    $sort_type = 'DESC';
                if ($request->sort_by == 'roles') {
                    $roles_only = true;
                }
                $users = $user->getUserWithRolesP($field, $sort_type, $paginate, $roles_only);
                return response()->json(view('admin.pages.roles.ajax', compact('users'))->render());

            } else {
                $search = $request->search;
                $users = $user->getSearchResultWithRolesP($search, $paginate);
                return response()->json(view('admin.pages.roles.ajax', compact('users'))->render());
            }

        }
        $users = $user->getUserWithRolesP($field, $sort_type, $paginate, $roles_only);
        return view('admin.pages.roles.index', compact('users'));
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $role = new Role();
        $data = User::where('id', $id)->with('roles')->first();
        $roles = $role->getAll();
        return view('admin.pages.roles.show', compact('data', 'roles'));
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
        $this->validate($request, [
            'role' => 'nullable|array',
            'is_active' => 'required|boolean',
        ]);
        $user = User::find($id);
        $user->is_active = $request->is_active;
        $user->save();

        $user->roles()->detach();
        if (is_array($request->role))
            $user->roles()->attach($request->role);

        return back()->with('message', 'Успешно обновленно');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
