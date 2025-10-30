<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeaturesTopNavbar extends Model
{
    protected $fillable = [
        'title',
        'text_color',
        'bg_color',
        'icon_bg_color',
    ];
}
