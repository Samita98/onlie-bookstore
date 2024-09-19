<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Form extends Model
{

	protected $fillable = ['name', 'email', 'success_msg', 'setup'];
	
	public function entries()
	{
	    return $this->hasMany('App\Model\Entries', 'form_id', 'id');
	}

}
