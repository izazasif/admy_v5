<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WebApi extends Model
{
    protected $fillable = ['acquisition','price','image','status'];
}
