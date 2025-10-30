<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeaturesSidebar extends Model
{
    protected $fillable = [
        'bg_color',
        'text_color',
        'hover_color',
        'active_color',
        'border_color',
    ];
}
