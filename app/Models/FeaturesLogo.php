<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeaturesLogo extends Model
{
     protected $fillable = [
        'filename',
        'image_path',
        'width',
        'height'
       
    ];
}
