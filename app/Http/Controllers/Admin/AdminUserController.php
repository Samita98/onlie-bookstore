<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Admin;

class AdminUserController extends Controller
{
	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = Admin::paginate(10);
        return view('admin.adminuser.list', ['users'=>$users, 'title'=>'Users List']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.adminuser.form', ['title'=>'Add Admin User']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = new Admin;
        $user->fill($request->except('password'));
        $user->password  = \Hash::make($request->get('password'));
        $user->save();
        return redirect(route('admin.admin.edit', $user->id));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = Admin::find($id);
        return view('admin.adminuser.form', ['user'=>$user, 'title' => 'Edit Admin User']);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = Admin::findOrFail($id);
        $user->fill($request->except('password'))->save();

       if ($request->filled('password')) {
            $user->password  = \Hash::make($request->get('password'));
            $user->save();
        }
        \Session::flash('success_message', 'User Detail successfully updated.');
        return redirect(route('admin.admin.edit', $user->id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = Admin::find($id);
        $user->delete();
        \Session::flash('success_message', 'Admin User deleted successfully.');
        return redirect(route('admin.admin.index'));
    }
}
