<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
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
        if (Request()->ajax()) {
            if ($request->sort_by != '') {
                $field = $request->sort_by;
                if ($field == 'priority')
                    $sort_type = 'DESC';
                $users = $user->getAllP($field, $sort_type, $paginate);
                return response()->json(view('admin.pages.users.ajax', compact('users'))->render());

            } else {
                $search = $request->search;
                $users = $user->getSearchResultP($search, $paginate);
                return response()->json(view('admin.pages.users.ajax', compact('users'))->render());
            }

        }
        $users = $user->getAllP($field, $sort_type, $paginate);
        return view('admin.pages.users.index', compact('users'));

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
        $this->validate($request, [
            'name' => 'required|string|min:3|max:60',
            'email' => 'required|string|min:3|max:60|unique:users,email',
            'is_representative' => 'required|boolean',
            'is_active' => 'required|boolean',
            'password' => 'required|string|min:6|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'is_representative' => $request->is_representative,
            'is_active' => $request->is_active,
            'password' => bcrypt($request->password),
        ]);
        return back()->with('message', 'Успешно добавленно');

    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = User::find($id);
        return view('admin.pages.users.show', compact('data'));
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
            'name' => 'required|string|min:3|max:60',
            'email' => 'required|string|min:3|max:60|unique:users,email,' . $id,
            'is_representative' => 'required|boolean',
            'is_active' => 'required|boolean',
        ]);
        $user = User::find($id);
        $user->update($request->all());
        if ($request->password != '') {
            $this->validate($request, [
                'password' => 'required|string|min:6|confirmed',
            ]);
            $user->password = Hash::make($request->password);
            $user->save();
        }

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
        $city = User::find($id);
        $city->delete();
        if (request()->ajax())
            return response()->json(['status' => 'success']);
        else
            return redirect()->route('users.index')->with('message', 'Удалено');
    }
}
