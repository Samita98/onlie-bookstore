<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Model\Author;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (isset($_GET['trashed'])) {
            $authors = Author::orderBy('deleted_at', 'desc')->onlyTrashed()->paginate(10);
        }else{
            $authors = Author::orderBy('id', 'desc')->paginate(10);
        }
        return view('admin.author.list', ['authors'=>$authors, 'title'=>'Author List']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.author.form', ['title'=>'Add Author']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $author = new Author;
        $author->title            =   $request->title;
        $author->permalink        =   generate_permalink($author, $request->permalink ? Str::slug($request->permalink) : Str::slug($request->title));
        $author->detail           =   $request->detail;
        $author->image            =   $request->image;
        $author->meta_title       =   $request->meta_title;
        $author->meta_description =   $request->meta_description;
        $author->meta_keyword     =   $request->meta_keyword;
        $author->meta_robot       =   $request->meta_robot;
        $author->save();
        return redirect(route('admin.author.edit', $author->id));
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
        $author = Author::findorFail($id);
        //print_r($author);
        return view('admin.author.form', ['author'=>$author, 'title' => 'Edit Author']);
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

        $author = Author::find($id);

        $author->title            =   $request->title;
        $author->permalink        =   generate_permalink($author, $request->permalink ? Str::slug($request->permalink) : Str::slug($request->title));
        $author->detail           =   $request->detail;
        $author->image            =   $request->image;
        $author->meta_title       =   $request->meta_title;
        $author->meta_description =   $request->meta_description;
        $author->meta_keyword     =   $request->meta_keyword;
        $author->meta_robot       =   $request->meta_robot;
        $author->save();
        \Session::flash('success_message', 'Author successfully Updated.');
        return redirect(route('admin.author.edit', $author->id));
    }
    public function restore(Request $request, $id)
    {

        $author = Author::withTrashed()->find($id);
        if($author){
            $author->restore();
            \Session::flash('success_message', 'Author restored successfully.');
            return redirect(route('admin.author.index').'?trashed');
        }else{
            return abort(404);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $author = Author::withTrashed()->find($id);
        if ($author->trashed()) {
            $author->forceDelete();

        \Session::flash('success_message', 'Author permanently deleted.');
        }else{
            $author->delete();
        \Session::flash('success_message', 'Author successfully moved to trash.');
        }
        return redirect(route('admin.author.index'));
    }
}
