<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Slider extends Model
{
    //
    use SoftDeletes;

	protected $fillable = ['title', 'caption', 'image', 'status'];

    protected $dates = ['deleted_at'];
    public function media()
    {
    	return $this->hasOne('App\Model\Media', 'id', 'image');
    }
}