<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Author extends Model
{
	use SoftDeletes;

	protected $fillable = ['title', 'permalink', 'detail', 'image', 'meta_title', 'meta_description', 'meta_keyword', 'meta_robot'];

    protected $dates = ['deleted_at'];
    public function media()
    {
    	return $this->hasOne('App\Model\Media', 'id', 'image');
    }
    public function products()
    {
    	return $this->hasMany('App\Model\Product');
    }

}