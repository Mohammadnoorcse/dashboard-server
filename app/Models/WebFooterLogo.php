<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WebFooterLogo extends Model
{
      protected $fillable = [
        'filename',
        'image',
        'width',
        'height',
        'status',
    ];
}
