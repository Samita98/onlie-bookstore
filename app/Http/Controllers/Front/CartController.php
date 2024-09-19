<?php

namespace App\Http\Controllers\Front;
use Validator;
use Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Cart;

class CartController extends Controller
{

   public function addProduct(Request $request, $id)
    {
        $product_id =$request->input('product_id');
        $product_qty = $request->input('product_qty');
		if(Auth::check())
		{

		$prod_check = Product::where('id',$product_id)->first();
		if($prod_check)
		{
			if(cart::where('product_id',$product_id)->where('user_id',Auth::id())->exists())
			{
				return response()->json(['status'=> $prod_check->name."Already addes to cart"]);
			}
			else
			{
		       $cartItem = new Cart();
		       $cartItem->product_id = $product_id;
		       $cartItem->user_id = Auth::id();
		       $cartItem->product_qty = $product_qty;
		       $cartItem->save();

		        return response()->json(['status' =>$prod_check->title."Addes to cart"]);
			}
		}
		 
		}
	}
    
}