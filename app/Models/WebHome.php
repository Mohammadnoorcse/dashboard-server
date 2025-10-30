<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WebHome extends Model
{
    protected $fillable = ['bgColor', 'textColor', 'hoverColor','activeColor','borderColor'];
}
