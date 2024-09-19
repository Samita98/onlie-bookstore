<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Page extends Model
{
	use SoftDeletes;

	protected $fillable = ['title', 'permalink', 'detail', 'image', 'meta_title', 'meta_description', 'meta_keyword', 'meta_robot'];

    protected $dates = ['deleted_at'];
    public function media()
    {
    	return $this->hasOne('App\Model\Media', 'id', 'image');
    }

}