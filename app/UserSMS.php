<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserSMS extends Model
{
    protected $table = 'user_s_m_s';
    protected $fillable = ['user_id','sms_id','package_id','channel','amount','valid_til','status','is_active','payment_status'];

    public function getUser(){
        return $this->belongsTo(
                'App\Models\User','user_id');
    }
}
