<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SMSText;
use App\SMSSchedule;
use App\UserSMS;
use Illuminate\Http\Request;

class SMSScheduleController extends Controller
{
    public function create()
    {
        $title = "AdMy | Create SMS Schedule";
        $is_active = "create_sms_schedule";
        $categories = Category::where('status', 1)->get();
        $sms_texts = SMSText::where('status', 1)->get();
        $user_id = session()->get('user_id');
        //get sms balance
        //---------------
        // $user_credit = UserSMS::where(['user_id'=>$user_id,'is_active'=>1])->where('valid_till', '>=', date('Y-m-d H:i:s'))->where('status', 1)->sum('amount');
        // $user_debit = SMSSchedule::where('user_id', $user_id)->sum('sms_amount');
        // $user_remaining = $user_credit-$user_debit;
        $push_debit = SMSSchedule::where('user_id', $user_id)->sum('sms_amount');
        $push_invalid = UserSMS::where(['user_id'=>$user_id, 'is_active'=>1, 'status'=>1])->where('valid_till', '<', date('Y-m-d H:i:s'))->sum('amount');
        $push_valid = UserSMS::where(['user_id'=>$user_id, 'is_active'=>1, 'status'=>1])->where('valid_till', '>=', date('Y-m-d H:i:s'))->sum('amount');
        $temp = $push_debit - $push_invalid;
        if($temp <= 0){
          $user_remaining = $push_valid;
        }else{
          $user_remaining = $push_valid - $temp;
        }
        //---------------
        //get sms balance
        session()->put('user_sms_credit', $user_remaining);

        return view('portal.sms_schedule.create', compact('title', 'is_active','categories','sms_texts'));
    }

    public function store(Request $request){
        $rules = [
            'schedule_datetime' => 'required',
            'category_id' => 'required',
            'app_id' => 'required',
            'app_name' => 'required',
            'ussd_code' => 'required',
            'sms_amount' => 'required',
            'sms_text_id' => 'required',
        ];

        $messages = [
            'schedule_datetime.required' => 'Select Date & Time field is required!',
            'category_id' => 'Category field is required!',
            'app_id.required' => 'App ID field is required!',
            'app_name.required' => 'App Name field is required!',
            'ussd_code.required' => 'USSD Code field is required!',
            'sms_amount.required' => 'SMS Amount field is required!',
            'sms_text_id.required' => 'SMS Clip field is required!',
        ];

        $this->validate($request, $rules, $messages);
        $user_id = session()->get('user_id');
        $user_credit = UserSMS::where(['user_id'=>$user_id,'is_active'=>1])->where('valid_till', '>=', date('Y-m-d H:i:s'))->where('status', 1)->sum('amount');
        $req_amount = $request->sms_amount;
        $user_debit = SMSSchedule::where('user_id', $user_id)->sum('sms_amount');
        $left = $user_debit+$req_amount;
        if($user_credit<$left){
            return redirect()->back()->withErrors("Please buy a package, You have no available sms credit");
        }


        $schedule_datetime = date('Y-m-d H:i:s', strtotime($request->schedule_datetime));
        $now = date('Y-m-d H:i:s');

        if($now > $schedule_datetime){
            return redirect()->back()->withErrors("Please schedule on a future date!");
        }

        $scheduleData = new SMSSchedule();
        $scheduleData->user_id = $user_id;
        $scheduleData->sms_text_id = $request->sms_text_id;
        $scheduleData->app_id = $request->app_id;
        $scheduleData->app_name = $request->app_name;
        $scheduleData->ussd_code = $request->ussd_code;
        $scheduleData->schedule_time = date('Y-m-d H:i:s', strtotime($request->schedule_datetime));
        $scheduleData->sms_amount = $request->sms_amount;
        $scheduleData->is_content_up_to_date = (isset($request->is_content_up_to_date)) ? 1: 0;
        $scheduleData->is_app_uat_done = (isset($request->is_app_uat_done)) ? 1: 0;
        $scheduleData->remark = $request->remark;
        $scheduleData->save();

        $user_debit = SMSSchedule::where('user_id', $user_id)->sum('sms_amount');
        $user_remaining = $user_credit-$user_debit;
        session()->put('user_sms_credit', $user_remaining);

        $message = 'Schedule saved successfully! In case of technical difficulties, we will deliver your schedule within 72 hours.';

        return redirect()->back()->with('message',$message);
    }

    public function list(Request $request)
    {
        $title = "AdMy | SMS Schedule List";
        $is_active = "sms_schedule_list";
        $all_schedule_list = SMSSchedule::paginate(20);
        return view('portal.sms_schedule.list', compact('title', 'is_active', 'all_schedule_list'));
    }

    public function listForUser(Request $request)
    {
        $user_id = session()->get('user_id');
        $title = "AdMy | SMS Schedule List";
        $is_active = "sms_schedule_list";
        $all_schedule_list = SMSSchedule::where('user_id',$user_id)->paginate(20);
        return view('portal.sms_schedule.user_list', compact('title', 'is_active', 'all_schedule_list'));
    }
}
