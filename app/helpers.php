<?php
use App\SMSSchedule;
use App\UserSMS;

if (! function_exists('getUserPushSMSBalance')) {
    function getUserPushSMSBalance($userID) {

        $push_debit = SMSSchedule::where('user_id', $userID)->sum('sms_amount');
        $push_invalid = UserSMS::where(['user_id'=>$userID, 'is_active'=>1, 'status'=>1])->where('valid_till', '<', date('Y-m-d H:i:s'))->sum('amount');
        $push_valid = UserSMS::where(['user_id'=>$userID, 'is_active'=>1, 'status'=>1])->where('valid_till', '>=', date('Y-m-d H:i:s'))->sum('amount');
        $temp = $push_debit - $push_invalid;
        if($temp <= 0){
          $balance = $push_valid;
        }else{
          $balance = $push_valid - $temp;
        }

        return $balance;
    }
}