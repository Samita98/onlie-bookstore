<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\User;
use Auth;

class UserController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (isset($_GET['trashed'])) {
            $users = User::orderBy('deleted_at', 'desc')->onlyTrashed()->paginate(10);
        }else{
            $users = User::paginate(10);
        }
        return view('admin.user.list', [
            'users'  => $users
        ]);
    }

    public function restore(Request $request, $id)
    {
        $user = User::withTrashed()->find($id);
        if($user){
            $user->restore();
            \Session::flash('success_message', 'User restored successfully.');
            return redirect(route('admin.user.index').'?trashed');
        }else{
            return abort(404);
        }
    }

    public function destroy($id)
    {
        $user = User::withTrashed()->find($id);
        if ($user->trashed()) {
            $user->forceDelete();
            \Session::flash('success_message', 'User permanently deleted.');
        }else{
            $user->delete();
            \Session::flash('success_message', 'User successfully moved to trash.');
        }
        return redirect(route('admin.user.index'));
    }
}