<?php

namespace App\Http\Controllers\Front;
use Validator;
use Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\CollaborativeRecommenderSystem;



class FrontController extends Controller
{
    public function detail($permalink)
    {
        $product = \App\Model\Product::where('permalink', $permalink)->firstOrFail();
        return view('front.product.detail', [
            'title' =>  $product->meta_title ?? $product->title,
            'meta_description' => $product->meta_description,
            'product'   =>  $product
        ]);
    }
    
    public function page_detail($permalink)
    {
        $page = \App\Model\Page::where('permalink', $permalink)->first();
         
        if($page){
            if ($page->meta_title) {
            $title = $page->meta_title;
        }else{
            $title = $page->title . ' - '. config('app.name', '');                
        }
            switch ($page->id) {
                case '2':
                    return view('front.page.contact', [
                            'title'=>$title,
                            'meta_description'=>$page->meta_description,
                            'page'=>$page,
                            'countries'     =>  \App\Model\Country::get()
                        ]);
                break;
                case '10':
                    return view('front.page.usedbook', [
                            'title'=>$title,
                            'meta_description'=>$page->meta_description,
                            'page'=>$page,
                            'usedbooks'=>  \App\Model\Product::where('product_type', "Used Books")->get(),
                        ]);
                break;
                default:
                    return view('front.page.detail', [
                        'title'=>$title,
                        'meta_description'=>$page->meta_description,
                        'page'=>$page,
                        'countries'     =>  \App\Model\Country::get()
                    ]);
                break;
            }
        }else{
            return abort(404);
        }
    }
    
    public function submit_form(Request $request, $id)
        {
            switch($id){
                case 1:
                $form = \App\Model\Form::find($id);
                    $validatedData = $request->validate([
                        'firstname' => 'required|max:190',
                        'lastname'  => 'required|max:190',
                        'email'     => 'required|email|max:190',
                        'message'   => 'required'
                    ]);
                    $fields = array(
                        'firstname' =>  'First Name',
                        'lastname'  =>  'Last Name',
                        'email'     =>  'Email',
                        'message'   =>  'Message'
                );
    
    
                        $entry = new \App\Model\Entries;
                        $entry->form_id          =   $id;
                        $entry->submitted_url    =   url()->previous();
                        $entry->client_ip        =   $request->getClientIp();
                        $entry->user_agent       =   $request->header('User-Agent');
                        $entry->save();
    
                        $insert = array();
                        foreach($fields as $fkey => $field){
                            $insert[] = array(
                                'entry_id'      =>  $entry->id,
                                'field_name'    =>  $field,
                                'field_value'   =>  $request->$fkey
                            );
                        }
                        \App\Model\Entryfield::insert($insert);
                       \Session::flash('success_message', $form->success_msg);
                    return redirect(url()->previous());
                break;
                default:
                abort(404);
                break;
            }
            abort(404);
        }







 


}