<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
	use SoftDeletes;
	private static $items;

	protected $fillable = ['title', 'parent_id', 'permalink', 'detail', 'image', 'icon', 'meta_title', 'meta_description', 'meta_keyword', 'meta_robot', 'status', 'menu_order', 'parent_id'];

    protected $dates = ['deleted_at'];
    public function media()
    {
    	return $this->hasOne('App\Model\Media', 'id', 'image');
    }
    
    public function products()
    {
    	return $this->hasMany('App\Model\Product');
    }
    
    public static function get_parent_items($selected=array(), $current_item=null, $parent_id=0, $hyphen='')
    {
        if(!is_array($selected)){
            $selected = array($selected);
        }
    	$menuitems = Category::where(['parent_id' => $parent_id]);
		if($current_item!=null){
			$menuitems->where('id', '!=', $current_item);
		}
		$menuitems = $menuitems->orderBy('menu_order', 'DESC')->get();
		foreach ($menuitems as $key => $menuitem) {

			self::$items .='<option ';
			if (in_array($menuitem->id, $selected)) {
				self::$items .=' selected="" ';
			}
			self::$items .=' value="'.$menuitem->id.'">'.$hyphen.$menuitem->title.'</option>';
			self::get_parent_items($selected, $current_item, $menuitem->id, $hyphen.' -- ');
		}
		return self::$items;
    }
    public static function category_list($parent_id=0, $hyphen='', $returnarray=[])
    {
    	$menuitems = self::where(['parent_id'=>$parent_id])->orderBy('menu_order', 'DESC')->get();
    	foreach ($menuitems as $key => $menuitem) {
			$menuitem->title = $hyphen.$menuitem->title;
    		$returnarray[] = $menuitem;
    		$returnarray = self::category_list($menuitem->id, $hyphen.' -- ', $returnarray);
    	}
		return $returnarray;
    }
    
    public function all_child_ids($parent_id)
    {
       $parent_idss = [$parent_id];
       $parent_ids = self::where('parent_id', $parent_id)->pluck('id')->toArray();
        if (is_array($parent_ids)) {
            $parent_idss = array_merge($parent_idss, $parent_ids);
        }
        for ($i=0; $i < 5; $i++) {
            if ($parent_ids) {
                $parent_ids = self::whereIn('parent_id', $parent_ids)->pluck('id')->toArray();
                if (is_array($parent_ids)) {
                     $parent_idss = array_merge($parent_idss, $parent_ids);
                }
            }
        }
        return $parent_idss;
    }
    public function children()
    {
        return $this->hasMany('App\Model\Category', 'parent_id', 'id');
    }
}
