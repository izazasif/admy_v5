<?php
use App\SMSSchedule;
use App\UserSMS;
use App\Models\Schedule;
use App\Models\UserPack;

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

if (! function_exists('getUserOBDBalance')) {
  function getUserOBDBalance($userID) {

      $obd_debit = Schedule::where('user_id', $userID)->sum('obd_amount');
      $obd_invalid = UserPack::where(['user_id'=>$userID, 'status'=>1])->where('valid_till', '<', date('Y-m-d H:i:s'))->sum('amount');
      $obd_valid = UserPack::where(['user_id'=>$userID, 'status'=>1])->where('valid_till', '>=', date('Y-m-d H:i:s'))->sum('amount');
      $temp = $obd_debit - $obd_invalid;
      if($temp <= 0){
        $balance = $obd_valid;
      }else{
        $balance = $obd_valid - $temp;
      }

      return $balance;
  }
}