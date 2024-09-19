<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Review extends Model
{
	use SoftDeletes;
	
	protected $fillable = ['product_id', 'user_id', 'review', 'rating'];
	
	public function user()
	{
		return $this->belongsTo('App\User');
	}

//change
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
