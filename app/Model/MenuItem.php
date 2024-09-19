<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
	protected $fillable = ['menu_id', 'parent_id', 'menu_title', 'menu_link', 'menu_class', 'menu_target', 'link_type', 'dbname', 'custom_link'];
    //
    /*public function get_title()
    {
		if ($this->link_type==1 || !empty($this->title)) {
			return $this->title;
		}else{
			return \DB::table($this->dbname)->where('id', $this->menu_link)->get()->first()->title;
		}
    }*/

}
