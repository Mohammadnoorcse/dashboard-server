<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name', 'short_desc', 'description', 'regular_price', 'sale_price', 'sku',
        'stock', 'status', 'currency', 'tax_status_id', 'shipping_id', 'color_id', 'size_id',
        'categories_id', 'brands_id', 'section_id', 'discount_id', 'coupon_id', 'user_id', 'images'
    ];

    protected $casts = [
    'tax_status_id' => 'array',
    'shipping_id' => 'array',
    'color_id' => 'array',
    'size_id' => 'array',
    'categories_id' => 'array',
    'brands_id' => 'array',
    'section_id' => 'array',
    'images' => 'array',
];



}
