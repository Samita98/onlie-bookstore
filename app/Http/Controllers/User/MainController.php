<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Order;
use App\Model\Review;
use App\Model\OrderItem;
use Auth;

class MainController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('user.index');
    }

    public function add_review(Request $request, $id)
    {
        // Check if the user is authenticated
        if (Auth::check()) {
            $user = Auth::user();

        // Check if the user has ordered the product
        $hasOrderedProduct = $user->orders()->whereHas('orderItems', function ($query) use ($id) {
            $query->where('product_id', $id);
        })->exists();


            if ($hasOrderedProduct) {
                // User has ordered the product, allow them to submit the review
                $validatedData = $request->validate([
                    'rating' => 'required|max:5',
                    'review' => 'required',
                ]);

                // Create the review
                $review = new Review();
                $review->user_id = $user->id;
                $review->product_id = $id;
                $review->review = $request->review;
                $review->rating = $request->rating;
                $review->submitted_url = url()->previous();
                $review->client_ip = $request->getClientIp();
                $review->user_agent = $request->header('User-Agent');
                $review->save();

                session()->flash('success_message', 'Review successfully added.');
                return redirect()->back();
            } else {
                // User has not ordered the product, display error message
                return redirect()->back()->with('error_message', 'You must order this product before reviewing it.');
            }
        } else {
            // User is not authenticated, redirect to login
            return redirect()->route('login')->with('error_message', 'Please log in to write a review.');
        }
    }


}