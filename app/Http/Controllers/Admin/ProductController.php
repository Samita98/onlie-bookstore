<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Model\Product;
use App\Model\Category;
use App\User;
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
            $products = Product::orderBy('deleted_at', 'desc')->onlyTrashed()->paginate(10);
        }else{
            $products = Product::paginate(10);
        }
        return view('admin.product.list', [
            'products'  => $products
        ]);
    }
 
    public function store(Request $request)
    {
        $product = new Product;
        $product->admin_id = \Auth::guard('admin')->user()->id;

        $product->title             = $request->title;
        $product->image             = $request->image;
        $product->permalink         =   generate_permalink($product, $request->permalink ? Str::slug($request->permalink) : Str::slug($request->title));
        $product->category_id       = $request->category_id;
        $product->author_id          = $request->author_id;
        $product->price             = $request->price;
        $product->detail            = $request->detail;
        $product->product_type      = $request->product_type;
        

        $product->meta_title = $request->meta_title;
        $product->meta_description = $request->meta_description;
        $product->meta_keyword = $request->meta_keyword;
        $product->meta_robot = $request->meta_robot;

        $product->save();
        
        return redirect(route('admin.product.edit', $product->id));
    }
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::category_list();
        return view('admin.product.form', [
            'category_items'    =>  Category::get_parent_items($product->category_id),
            'product'           =>  $product,
            'authors'            =>  \App\Model\Author::get(),
            'title'             =>  'Edit Product'
        ]);
    }
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $product->title             = $request->title;
        $product->image             = $request->image;
        $product->permalink         =   generate_permalink($product, $request->permalink ? Str::slug($request->permalink) : Str::slug($request->title));
        $product->category_id       = $request->category_id;
        $product->author_id          = $request->author_id;
        $product->price             = $request->price;
        $product->detail            = $request->detail;
        $product->product_type      = $request->product_type;

        $product->meta_title        = $request->meta_title;
        $product->meta_description  = $request->meta_description;
        $product->meta_keyword      = $request->meta_keyword;
        $product->meta_robot        = $request->meta_robot;
        
        $product->save();
        \Session::flash('success_message', 'Product successfully Updated.');
        return redirect(route('admin.product.edit', $product->id));
    }
    public function ajax(Request $request)
    {
        if(isset($request->action)){
            switch($request->action){
                case 'change_featured':
                    $id = $_POST['post_id'];
                    $ad = Product::findOrfail($id);
                    if($ad->featured_at){
                        $ad->featured_at=null;
                    }else{                        
                        $ad->featured_at=date('Y-m-d H:i:s');
                    }
                    $ad->save();

					if ($ad->featured_at) {
					 	$status = '<i class="fa fa-check btn btn-xs btn-success" aria-hidden="true"></i>';
					}else{
						$status = '<i class="fa fa-times btn btn-xs btn-danger" aria-hidden="true"></i>';
					}

					return json_encode(array('success'=>'true','message'=>'Status has been changed','contents'=>$status));
                break;
                case 'change_latest':
                    $id = $_POST['post_id'];
                    $ad = Product::findOrfail($id);
                    if($ad->latest_product){
                        $ad->latest_product=null;
                    }else{                        
                        $ad->latest_product=date('Y-m-d H:i:s');
                    }
                    $ad->save();

					if ($ad->latest_product) {
					 	$status = '<i class="fa fa-check btn btn-xs btn-success" aria-hidden="true"></i>';
					}else{
						$status = '<i class="fa fa-times btn btn-xs btn-danger" aria-hidden="true"></i>';
					}

					return json_encode(array('success'=>'true','message'=>'Status has been changed','contents'=>$status));
                break;
                case 'change_trending':
                    $id = $_POST['post_id'];
                    $ad = Product::findOrfail($id);
                    if($ad->trending_product){
                        $ad->trending_product=null;
                    }else{                        
                        $ad->trending_product=date('Y-m-d H:i:s');
                    }
                    $ad->save();

					if ($ad->trending_product) {
					 	$status = '<i class="fa fa-check btn btn-xs btn-success" aria-hidden="true"></i>';
					}else{
						$status = '<i class="fa fa-times btn btn-xs btn-danger" aria-hidden="true"></i>';
					}

					return json_encode(array('success'=>'true','message'=>'Status has been changed','contents'=>$status));
                break;
                case 'change_status':
                    $id = $_POST['post_id'];
                    $ad = Ad::findOrfail($id);
                    if($ad->status){
                        $ad->status=0;
                    }else{
                        $ad->status=1;
                    }
                    $ad->save();

					if ($ad->status) {
					 	$status = '<i class="material-icons">check_circle</i>';
					}else{
						$status = '<i class="material-icons col-red">remove_circle</i>';
					}

					return json_encode(array('success'=>'true','message'=>'Status has been changed','contents'=>$status));
                break;
                default:
                
                break;
            }
        }
        return abort(404);
    }
    
    public function restore(Request $request, $id)
    {
        $product = Product::withTrashed()->find($id);
        if($product){
            $product->restore();
            \Session::flash('success_message', 'Product restored successfully.');
            return redirect(route('admin.product.index').'?trashed');
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
        return redirect(route('admin.product.index'));
    }
}