<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Product;
use App\Model\Category;
use Auth;

class ProductController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (isset($_GET['trashed'])) {
            $products = Product::where('user_id', Auth::guard('web')->user()->id)->orderBy('deleted_at', 'desc')->onlyTrashed()->get();
        }else{
            $products = Product::where('user_id', Auth::guard('web')->user()->id)->paginate(10);
        }
        return view('user.product.list', [
            'products'  => $products
        ]);
    }
    public function create()
    {
        $categories = Category::category_list();
        return view('user.product.form', [
            'categories'    =>  $categories,
            'authors'       =>  \App\Model\Author::get(),
            'title'             =>  'Add Product'
        ]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'title' =>  'required|min:5|max:190|regex:/(^[a-zA-Z0-9 ]+$)+/',
            'category_id'   =>  'required|numeric',
            'price'         =>  'numeric',
            'detail'      =>  'sometimes|nullable',
        ]);
        $product = new Product;
        $product->user_id = Auth::guard('web')->user()->id;


        
        $product->title = $request->title;
        $product->image = $request->image;
        $product->permalink = generate_permalink($product, $request->title);
        $product->category_id = $request->category_id;
        $product->author_id          = $request->author_id;
        $product->product_type      = $request->product_type;
        $product->price = $request->price;
        $product->detail = $request->detail;
        $product->save();
        \Session::flash('success_message', 'Product added successfully.');
        return redirect(route('user.product.edit', $product->id));
    }
    public function edit($id)
    {
        $product = Product::where('user_id', Auth::guard('web')->user()->id)->findOrFail($id);
        $categories = Category::category_list();
        return view('user.product.form', [
            'categories'    =>  $categories,
            'product'       =>  $product,
            'authors'            =>  \App\Model\Author::get(),
            'title'         =>  'Edit Product'
        ]);
    }
    public function update(Request $request, $id)
    {
        $product = Product::where('user_id', Auth::guard('web')->user()->id)->findOrFail($id);
        $request->validate([
            'title' =>  'required|min:5|max:190|regex:/(^[a-zA-Z0-9 ]+$)+/',
            'category_id'   =>  'required|numeric',
            'price'         =>  'numeric',
            'detail'      =>  'sometimes|nullable',
        ]);
        $product->user_id = Auth::guard('web')->user()->id;
        $product->title = $request->title;
        $product->image = $request->image;
        $product->permalink = generate_permalink($product, $request->title);
        $product->category_id = $request->category_id;
        $product->author_id          = $request->author_id;
        $product->product_type      = $request->product_type;
        $product->price = $request->price;
        $product->detail = $request->detail;
        $product->save();
        \Session::flash('success_message', 'Product upadted successfully.');
        return redirect(route('user.product.edit', $product->id));
    }

    public function restore(Request $request, $id)
    {
        $product = Product::withTrashed()->find($id);
        if($product){
            $product->restore();
            \Session::flash('success_message', 'Product restored successfully.');
            return redirect(route('user.product.index').'?trashed');
        }else{
            return abort(404);
        }
    }

    public function destroy($id)
    {
        $product = Product::withTrashed()->find($id);
        if ($product->trashed()) {
            $product->forceDelete();
            \Session::flash('success_message', 'Product permanently deleted.');
        }else{
            $product->delete();
            \Session::flash('success_message', 'Product successfully moved to trash.');
        }
        return redirect(route('user.product.index'));
    }

}