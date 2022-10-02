<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserWebAPI extends Model
{
    protected $table = 'user_web_a_p_i_s';
    protected $fillable = ['user_id','web_api_id','acquisition','price','status','payment_status'];
}
