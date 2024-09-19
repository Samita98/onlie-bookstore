<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Setting;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.setting.site', array('title'=>'Site Configuration'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $configurations = array(
            'facebook'  =>'Facebook URL',
            'twitter'   =>'Twitter URL',
            'linkedin'  =>'Linkedin URL',
            'instagram' =>'Instagram',
            'mobile'    =>'Mobile No.',
            'smobile'   =>'Secondary Mobile No.',
            'location'  =>'Location',
            'contact'   =>'Contact No.',
            'youtube'   =>'Youtube',
            'pemail'    =>'Primary Email',
            'semail'    =>'Secondary Email'
        );
        foreach ($configurations as $key => $value) {
            $setting = Setting::firstOrNew(array('name' => $key));
            $setting->value = $request->$key;
            $setting->save();
        }
         return redirect()->back()->with('success_message', 'Settings has been saved.');        
    }
    
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function home()
    {
        return view('admin.setting.home', array('title'=>'Home Configuration'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function home_store(Request $request)
    {
        $configurations = array(
            'meta_title',
            'meta_description',
            'meta_keyword',
            'home_welcome',
        );
        foreach ($configurations as $key => $value) {
            $setting = Setting::firstOrNew(array('name' => $value));
            $setting->value = $request->$value;
            $setting->save();
        }
         return redirect()->back()->with('success_message', 'Settings has been saved.');        
    }
    
    
    
    
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function ldocuments()
    {
        return view('admin.setting.ldocuments', array('title'=>'Legal Documents'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function ldocuments_store(Request $request)
    {
        
        $setting = Setting::firstOrNew(array('name' => 'ldocuments'));
        $setting->value = @serialize($request->ldocuments);
        $setting->save();
        
        
        
         return redirect()->back()->with('success_message', 'Settings has been saved.');        
    }
    
    
        
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function homeimages()
    {
        return view('admin.setting.homeimages', array('title'=>'Home Images'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function homeimages_store(Request $request)
    {
        
        
        $configurations = array(
            'logo',
            'firstparallax',
        );
        foreach ($configurations as $key => $value) {
            $setting = Setting::firstOrNew(array('name' => $value));
            $setting->value = $request->$value;
            $setting->save();
        }
        
         return redirect()->back()->with('success_message', 'Settings has been saved.');        
    }
}
