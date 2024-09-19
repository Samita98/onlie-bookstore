<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Entries extends Model
{

	protected $fillable = ['form_id', 'submitted_url', 'client_ip', 'user_agent'];

	public function fields()
	{
		return $this->hasMany('App\Model\Entryfield', 'entry_id');
	}

}
