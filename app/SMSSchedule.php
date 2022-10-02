<?php

namespace App;

use App\Models\SMSText;
use Illuminate\Database\Eloquent\Model;

class SMSSchedule extends Model
{
    protected $table = 's_m_s_schedules';
    protected $fillable = ['user_id','app_id','sms_text_id','app_name','ussd_code','keyword',
        'remark','schedule_time','actual_delivery_time','sms_amount','is_content_up_to_date',
        'is_app_uat_done','status'];
    public function getUser(){
        return $this->belongsTo(
            'App\Models\User','user_id');
    }
    public function text(){
        return $this->belongsTo(SMSText::class,'sms_text_id');
    }
}
