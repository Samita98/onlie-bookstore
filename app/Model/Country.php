<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Country extends Model
{
	protected $fillable = ['iso', 'name', 'nicename', 'iso3', 'numcode', 'phonecode'];

    protected $table = 'countries';
}