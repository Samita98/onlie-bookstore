<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class ProfileController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function edit()
    {
        $profile = Auth::guard('web')->user();
        return view('user.profile.form',['profile'=>$profile]);
    }
    
    public function update(Request $request)
    {   $request->validate([
            'name'          =>  'required',
            'email'         =>  'required|email|max:190',
            'phone_no'      =>  'required'
        ]);
        $profile = Auth::guard('web')->user();
        $profile->name = $request->name;
        $profile->email = $request->email;
        $profile->phone_no = $request->phone_no;
        $profile->whatsapp_no = $request->whatsapp_no;
        $profile->save();
        \Session::flash('success_message', 'Profile successfully updated.');
        return redirect(route('user.profile.edit', $profile->id));
    }
    
}