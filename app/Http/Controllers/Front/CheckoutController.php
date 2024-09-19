<?php

namespace App\Http\Controllers\Front;
use Validator;
use Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Model\Order;
use App\Model\OrderItem;
use App\Model\Review;
use Cart;

class CheckoutController extends Controller
{
    public function index()
    {
    // Check if the user is authenticated
    if (Auth::check()) {
        // If the user is authenticated, retrieve their products
        $cart = Auth::user()->products;
        $userID       = Auth::user()->id;
        $userProduct  = Auth::user()->product_id;  
    } else {
         
        // If the user is not authenticated, handle it accordingly
        // For example, you can redirect them to the login page or display a message
        return redirect()->route('login')->with('error_message', 'Please log in to proceed with the checkout.');
        // Here we're just assigning an empty array to $cart
        $cart = [];
    } 

    return view('front.cart.checkout', compact('cart'));

    }


    public function placeorder(Request $request)
    {
        // Check if the user is authenticated
        if (Auth::check()) {
            $order = new Order();
            $order->name = $request->input('name');
            $order->email = $request->input('email');
            $order->phone_no = $request->input('phone_no');
            
            // Associate the order with the authenticated user
            $order->user_id = Auth::id(); // Associate the order with the authenticated user
            
            $order->save();

            $cart = Cart::getContent();
            foreach ($cart as $item ) 
            {
                OrderItem::create([
                    'order_id'      => $order->id,
                    'product_id'    => $item->id,
                    'quantity'      => $item->quantity,
                    'price'         => $item->price,
                ]);
            }
            Cart::clear();

            // Update user details if necessary
            $user = Auth::user();
            if ($user->name == null) {
                $user->name = $request->input('name');
                $user->email = $request->input('email');
                $user->phone_no = $request->input('phone_no');
                $user->save();
            }
            
            \Session::flash('success_message', 'Order placed successfully. Thank you!');
            return view('front.cart.payment', compact('cart'));
        } else {
            return redirect()->route('login')->with('success_message', 'Please log in to place an order.');
        }
    }
    
}