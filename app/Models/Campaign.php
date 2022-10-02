<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    protected $table = 'campaigns';
    protected $fillable = ['user_id','campaign_id','app_id','conversions','sent','delivered','parked','status'];
}
