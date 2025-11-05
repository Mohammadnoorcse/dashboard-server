<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
     protected $fillable = [
        'user_id',
        'name',
        'phone',
        'email',
        'emergency_phone',
        'country',
        'district',
        'city',
        'address',
        'delivery_method',
        'note',
        'total_amount',
        'status',
    ];

    // public function items()
    // {
    //     return $this->hasMany(OrderItem::class);
    // }
    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id')->with('product');
    }
}
