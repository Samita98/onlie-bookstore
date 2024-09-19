<?php

namespace App\Http\Controllers\Front;

use Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Order;
use Cart;

class ProductController extends Controller
{
    public function load_product($permalink)
    {
        $product = \App\Model\Product::where('permalink', $permalink)->firstOrFail();
        if ($product->meta_title) {
            $title = $product->meta_title;
        }else{
            $title = $product->title . ' - '. config('app.name', '');                
        }
        $image = '';
        if($product->media){
            $image = $product->media->get_attachment_url();
        }
        return view('front.product.detail', [
            'title'     =>  $title,
            'product'   =>  $product,
            'image'     =>  $image,
            'relatedproducts'   =>  \App\Model\Product::where('category_id', $product->category_id)->where('id', '!=', $product->id)->limit(12)->get(),
            'reviews'       =>  \App\Model\Review::where('product_id', $product->id)->get(),
        ]);
    }
    
    public function load_category($permalink)
    {
        $category = \App\Model\Category::where('permalink', $permalink)->first();
        
        if ($category) {
            if ($category->meta_title) {
            $title = $category->meta_title;
        }else{
            $title = $category->title . ' - '. config('app.name', '');                
        }
            return view('front.category.detail', [
                    'title'     =>  $title,
                    'meta_description'=>$category->meta_description,
                    'category'   =>  $category,
                    'categorylists'   =>  \App\Model\Category::where('id','!=',$category->id)->orderBy('id', 'DESC')->get()
                ]);
        }
        
        return abort(404);
    }
    
    public function load_author($permalink)
    {
        $author = \App\Model\Author::where('permalink', $permalink)->first();
        
        if ($author) {
            if ($author->meta_title) {
            $title = $author->meta_title;
        }else{
            $title = $author->title . ' - '. config('app.name', '');                
        }
            return view('front.author.detail', [
                    'title'     =>  $title,
                    'meta_description'=>$author->meta_description,
                    'author'   =>  $author,
                    'authorlists'   =>  \App\Model\Author::where('id','!=',$author->id)->orderBy('id', 'DESC')->get()
                ]);
        }
        
        return abort(404);
    }
    
    public function author_list()
    {
        return view('front.author.list', [
                'title'=>'All Authors',
                'author'   =>  \App\Model\Author::orderBy('id', 'desc')->get()
            ]);
    }

   public function search(Request $request)
    {
        $qkeyword = $request->input('keyword');

         $fproducts = \App\Model\Product::where(function($q) use ($qkeyword){
             $q->where('title', 'LIKE', '%'.$qkeyword.'%');
             $q->orWhere('meta_keyword', 'LIKE', '%'.$qkeyword.'%');
         })
         ->with('user')->has('user')->get();

        return view('front.search')->with('fproducts', $fproducts)->with('query', $qkeyword);
    }
    
    public function add_cart(Request $request, $id)
    {
        $product = \App\Model\Product::findOrFail($id);

        Cart::add(array(
            'id' => $product->id,
            'name' => $product->title,
            'price' => $product->price,
            'quantity' => $request->product_quantity,
            'associatedModel' => $product
        ));
        return redirect()->back();
    }
    
    public function update_cart(Request $request, $id)
    {
        $product = \App\Model\Product::findOrFail($id);

        Cart::remove($product->id);
        Cart::add(array(
            'id' => $product->id,
            'name' => $product->title,
            'price' => $product->price,
            'quantity' => $request->product_quantity,
            'associatedModel' => $product
        ));
        return redirect()->back();
    }
    public function remove_cart(Request $request, $product_id)
    {
        $sku = \App\Model\Product::findOrFail($product_id);
        Cart::remove($sku->id);
        return redirect()->back();
    }
    public function view_cart()
    {
        $cart = new \Cart;

        //return view('public.cart.index', compact('cart', 'countries'));
        return view('front.cart.list', [
                'title' =>  'Cart',
                'cart' => $cart
            ]);
    }



   public function checkout()
    {
        if(Auth::check())
        {


            return redirect()->route('checkout');
        }
        else{
            return redirect()->route('login');
        }
       
    }



}