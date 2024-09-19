<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Model\Slider;
use \App\Model\Review;
use \App\Model\Product;
use App\Services\CollaborativeRecommenderSystem;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $recommendedProducts = [];

        if (Auth::check()) {
            $userId = Auth::id();
            $userReviewsCount = Review::where('user_id', $userId)->count();

            // Check if the user has provided at least one review
            if ($userReviewsCount > 0) {
                $collaborativeRecommender = new CollaborativeRecommenderSystem();
                $recommendedProducts = $collaborativeRecommender->suggestProductsFor($userId);
            }
        }



        return view('front.home', [
                'title'         =>  \App\Model\Setting::where('name', 'meta_title')->first()->value,
                'meta_description'  =>  \App\Model\Setting::where('name', 'meta_description')->first()->value,
                'meta_keyword'  =>  \App\Model\Setting::where('name', 'meta_keyword')->first()->value,
                'sliders'       => Slider::orderBy('menu_order', 'desc')->get(),
                'fproducts'     =>  \App\Model\Product::whereNotNull('featured_at')->has('category')->with('category')->get(),
                'latestproducts'=>  \App\Model\Product::whereNotNull('latest_product')->has('category')->with('category')->get(),
                'recommendedProducts' => $recommendedProducts

                
            ]
        );
    }



}
