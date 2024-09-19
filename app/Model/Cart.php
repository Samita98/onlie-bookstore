<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{

	protected $fillable = ['user_id', 'product_id', 'product_qty'];
	

	public function products()
	{
		return $this->belongsTo(product::class,'product_id','id');
	}

}
