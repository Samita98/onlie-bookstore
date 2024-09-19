<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('admin.index',[
        	'forms'=>\App\Model\Form::orderBy('id', 'desc')->paginate(5),
        	'reviews'=>\App\Model\Review::orderBy('id', 'desc')->limit(5)->get()

        ]); 
    }
}
