<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;



class Order extends Model
{
    protected $fillable = ['name', 'email', 'phone_no', 'user_id'];

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->hasManyThrough(Product::class, OrderItem::class);
    }

}
