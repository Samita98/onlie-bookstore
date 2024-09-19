<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Category;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (isset($_GET['trashed'])) {
            $categories = Category::orderBy('deleted_at', 'desc')->onlyTrashed()->get();
        }else{
            $categories = Category::category_list();
        }
        return view('admin.category.list', ['categories'=>$categories, 'title'=>'Categories List']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.category.form', ['title'=>'Add Category', 'parent_items'=>Category::get_parent_items(array())]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $category = new Category;
        $category->title            =   $request->title;
        $category->permalink        =   generate_permalink($category, $request->permalink ? Str::slug($request->permalink) : Str::slug($request->title));
        $category->detail           =   $request->detail;
        $category->image            =   $request->image;
        $category->meta_title       =   $request->meta_title;
        $category->meta_description =   $request->meta_description;
        $category->meta_keyword     =   $request->meta_keyword;
        $category->meta_robot       =   $request->meta_robot;
        $category->parent_id        =   $request->parent_id;
        $category->icon             =   $request->icon;
        $category->save();
        \Session::flash('success_message', 'Category successfully added.');
        return redirect(route('admin.category.edit', $category->id));
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
        $category = Category::findorFail($id);
        return view('admin.category.form', ['category'=>$category, 'title' => 'Edit Category', 'parent_items'=>Category::get_parent_items($category->parent_id, $category->id)]);
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

        $category = Category::find($id);

        $category->title            =   $request->title;
        $category->permalink        =   generate_permalink($category, $request->permalink ? Str::slug($request->permalink) : Str::slug($request->title));
        $category->detail           =   $request->detail;
        $category->image            =   $request->image;
        $category->meta_title       =   $request->meta_title;
        $category->meta_description =   $request->meta_description;
        $category->meta_keyword     =   $request->meta_keyword;
        $category->meta_robot       =   $request->meta_robot;
        $category->parent_id        =   $request->parent_id;
        $category->icon             =   $request->icon;
        $category->save();
        \Session::flash('success_message', 'Category successfully Updated.');
        return redirect(route('admin.category.edit', $category->id));
    }
    public function restore(Request $request, $id)
    {

        $category = Category::withTrashed()->find($id);
        if($category){
            $category->restore();
            \Session::flash('success_message', 'Category restored successfully.');
            return redirect(route('admin.category.index').'?trashed');
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
        $category = Category::withTrashed()->find($id);
        if ($category->trashed()) {
            $category->forceDelete();

        \Session::flash('success_message', 'Category permanently deleted.');
        }else{
            $category->delete();
        \Session::flash('success_message', 'Category successfully moved to trash.');
        }
        return redirect(route('admin.category.index'));
    }
}
