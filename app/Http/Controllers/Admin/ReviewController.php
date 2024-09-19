<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Review;


class ReviewController extends Controller
{
	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (isset($_GET['trashed'])) {
            $reviews = Review::orderBy('deleted_at', 'desc')->onlyTrashed()->paginate(10);
        }else{
            $reviews = Review::orderBy('id', 'desc')->paginate(10);
        }
        return view('admin.review.list', ['reviews'=>$reviews, 'reviewer_name'=>'Review List']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $review = new Review;
        $review->fill($request->all())->save();
        return redirect(route('admin.review.edit', $review->id));
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
 
    }
    public function restore(Request $request, $id)
    {
        $review = Review::withTrashed()->find($id);
        if($review){
            $review->restore();
            \Session::flash('success_message', 'Review restored successfully.');
            return redirect(route('admin.review.index').'?trashed');
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
        $review = Review::withTrashed()->find($id);
        if ($review->trashed()) {
            $review->forceDelete();
            \Session::flash('success_message', 'Review deleted permanently.');
            return redirect(route('admin.review.index').'?trashed');
        }else{
            $review->delete();
            \Session::flash('success_message', 'Review moved to trash.');
            return redirect(route('admin.review.index'));
        }
    }
}
