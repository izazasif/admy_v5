<?php
use App\SMSSchedule;
use App\UserSMS;
use App\Models\Schedule;
use App\Models\UserPack;
use App\Models\Log;

if (! function_exists('getUserPushSMSBalance')) {
    function getUserPushSMSBalance($userID) {

        $push_debit = SMSSchedule::where('user_id', $userID)->whereNotIn('status',[-1])->sum('sms_amount');
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

      $obd_debit = Schedule::where('user_id', $userID)->whereNotIn('status',[-1])->sum('obd_amount');
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

if (! function_exists('storeActivityLog')) {
  function storeActivityLog($name,$activity,$data=null) {
      $user_id = session()->get('user_id');
      $logData = new Log;
      $logData->module_name = $name;
      $logData->module_activity = $activity;
      $logData->user_data = $data;
      $logData->user_id = $user_id;
      $logData->save();
      return true;
  }
}