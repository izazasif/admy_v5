<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WebAPISchedule extends Model
{
    protected $table = 'web_a_p_i_schedules';
    protected $fillable = ['user_id','dev_name','dev_email','dev_number','app_name','app_id','category_id',
        'deposit_slip','status','schedule_time','app_type'];

    public function getUser(){
        return $this->belongsTo(
            'App\Models\User','user_id');
    }
    public function category(){
        return $this->belongsTo(
            'App\Models\Category','category_id','id');
    }
}
