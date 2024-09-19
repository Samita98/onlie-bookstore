<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\MenuItem;
use DB;

class Menu extends Model
{
	protected $fillable = ['menu'];
	private $parent_link = '';
   	private static $dbitems = array(
    			'pages'=>'',
                'blog'=>'blog/',
                'categories'=>''
    	);
    //
    public function get_parent_links($menucat, $selected=null, $current_item=null, $parent_id=0, $hyphen='')
    {
    	$menuitems = MenuItem::where(['parent_id' => $parent_id, 'menu_id'=>$menucat]);
		if($current_item!=null){
			$menuitems->where('id', '!=', $current_item);
		}
		$menuitems = $menuitems->orderBy('menu_order', 'DESC')->get();
		foreach ($menuitems as $key => $menuitem) {
			$menutitle = '';
			if ($menuitem->link_type==0 && empty($menuitem->menu_title)) {
			 $mmitem = \DB::table($menuitem->dbname)->where('id', $menuitem->menu_link)->get()->first();
    			if($mmitem){	
                    $menutitle = $mmitem->title;
                }
				
			}else{
				$menutitle = $menuitem->menu_title;
			}
			$this->parent_link .='<option ';
			if ($selected==$menuitem->id) {
				$this->parent_link .=' selected="" ';
			}
			$this->parent_link .=' value="'.$menuitem->id.'">'.$hyphen.$menutitle.'</option>';
			$this->get_parent_links($menucat, $selected, $current_item, $menuitem->id, $hyphen.' -- ');
		}
		return $this->parent_link;		
    }
    public static function menulists($menucat, $parent_id=0, $hyphen='', $returnarray=[])
    {
    	$menuitems = MenuItem::where(['menu_id' => $menucat, 'parent_id'=>$parent_id])->orderBy('menu_order', 'DESC')->get();
    	foreach ($menuitems as $key => $menuitem) {
    		if ($menuitem->link_type==0 && empty($menuitem->menu_title)) {
    		  $mmitem = \DB::table($menuitem->dbname)->where('id', $menuitem->menu_link)->get()->first();
    			if($mmitem){
                    $menuitem->menu_title = $mmitem->title;	
                }	
			}
			$menuitem->menu_title = $hyphen.$menuitem->menu_title;
    		$returnarray[] = $menuitem;
    		$returnarray = self::menulists($menucat, $menuitem->id, $hyphen.' -- ', $returnarray);
    	}
		return $returnarray;
    }
    public static function getMenu($menucat){
    	$cases = '';
    	foreach (self::$dbitems as $dkey => $dbitem) {

        		$cases.='WHEN "'.$dkey.'"
                THEN (select p.title from '.DB::getTablePrefix().$dkey.' as p where p.id=v9617_m.menu_link limit 0, 1)
                ';
    	}
    	$cases2 = '';
    	foreach (self::$dbitems as $dkey => $dbitem) {
    		$cases2.='WHEN "'.$dkey.'"
            THEN (select p.permalink from '.DB::getTablePrefix().$dkey.' as p where p.id=v9617_m.menu_link limit 0, 1)
            ';
    	}
    	$menuitems = DB::table('menu_items as m')->where(['menu_id' => $menucat])
    	->select(['m.*', 
    DB::raw('(CASE v9617_m.dbname
            '.$cases.'
            ELSE ""
            END) as main_title'),
    DB::raw('(CASE v9617_m.dbname
            '.$cases2.'
            ELSE ""
            END) as main_permalink')])
				    	->orderBy('m.menu_order', 'DESC')
				    	->get();
		return self::getAllMenus($menuitems);
    }
    private static function getAllMenus($menuitems, $parentid=0){
    	$returnvar='';
        foreach ($menuitems as $key => $menuitem) {
        	if($parentid==$menuitem->parent_id){
	        	$submenus=self::getAllMenus($menuitems, $menuitem->id);
	        	if ($menuitem->link_type==0) {
    				if (empty($menuitem->menu_title)) {
    					$menuitem->menu_title = $menuitem->main_title;
    				}
    				$link = self::$dbitems[$menuitem->dbname].$menuitem->main_permalink;
    			}
	            $aclass='';
	            $returnvar.='<li';
	            $returnvar.=' class="nav-item menu-item menu-'.$menuitem->id.' '.$menuitem->menu_class;
	            if (!empty($submenus)) {
	                $returnvar.=' menu-item-has-children dropdown' ;
	            }
	            $returnvar.='" ';
	            $returnvar.='><a class="nav-link'.$aclass.'" ';
                
                if (!empty($submenus)) {
	                $returnvar.=' data-toggle="dropdown" ' ;
	            }
                
                
                 $returnvar.='href="';
	            if ($menuitem->link_type==true) {
	                $returnvar.=$menuitem->custom_link;
	            }else{
	                $returnvar.=url($link);
	            }
	            $returnvar.='">'.$menuitem->menu_title.'</a>';
				$returnvar.=$submenus;
	            $returnvar.='</li>';
	            unset($menuitems[$key]);
	        }
        }
        if ($parentid!=0 && !empty($returnvar)) {
    		return '<ul class="dropdown-menu">'.$returnvar.'</ul>';
        }
        return $returnvar;
    }
}