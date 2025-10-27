<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = [
        'name',
        'price',
        'type',
        'startDate',
        'endDate',
        'status',
    ];
}
