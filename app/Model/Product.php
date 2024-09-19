<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
	use SoftDeletes;

	protected $fillable = ['category_id', 'user_id', 'author_id', 'featured_at', 'latest_product', 
    'trending_product', 'title', 'permalink', 'detail', 'image','price', 
    'product_type', 'meta_title', 'meta_description', 'meta_keyword', 'meta_robot'];

    protected $dates = ['deleted_at'];
    public function media()
    {
    	return $this->hasOne('App\Model\Media', 'id', 'image');
    }
    public function category()
    {
        return $this->belongsTo('App\Model\Category');
    }
    public function author()
    {
        return $this->belongsTo('App\Model\Author');
    }
    public function user()
    {
        return $this->belongsTo('App\User');
    }

}