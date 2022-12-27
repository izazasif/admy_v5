<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\SMSSchedule;
use App\UserSMS;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\AudioClip;
use App\Models\Schedule;
use App\Models\UserPack;
use App\Models\Report;
use App\Models\User;

class ScheduleController extends Controller
{
    public function create()
    {
        $title = "AdMy | Create Schedule";
        $is_active = "create_schedule";
        $categorys = Category::where('status', 1)->get();
        $audio_clips = AudioClip::where('status', 1)->get();
        // $user_id = session()->get('user_id');
        //get sms balance 
        //---------------
        // $user_credit = UserSMS::where(['user_id'=>$user_id,'is_active'=>1])->where('valid_till', '>=', date('Y-m-d H:i:s'))->where('status', 1)->sum('amount');
        // $user_debit = SMSSchedule::where('user_id', $user_id)->sum('sms_amount');
        // $user_remaining = $user_credit-$user_debit;

        // $push_debit = SMSSchedule::where('user_id', $user_id)->sum('sms_amount');
        // $push_invalid = UserSMS::where(['user_id'=>$user_id, 'is_active'=>1, 'status'=>1])->where('valid_till', '<', date('Y-m-d H:i:s'))->sum('amount');
        // $push_valid = UserSMS::where(['user_id'=>$user_id, 'is_active'=>1, 'status'=>1])->where('valid_till', '>=', date('Y-m-d H:i:s'))->sum('amount');
        // $temp = $push_debit - $push_invalid;
        // if($temp <= 0){
        //   $user_remaining = $push_valid;
        // }else{
        //   $user_remaining = $push_valid - $temp;
        // }

        // $user_remaining = getUserPushSMSBalance($user_id);
        // session()->put('user_sms_credit', $user_remaining);
        //---------------
        //get sms balance

        return view('portal.schedule.create', compact('title', 'is_active', 'categorys', 'audio_clips'));
    }

    public function createSubmit(Request $request){
        $rules = [
            'schedule_datetime' => 'required',
            'category_id' => 'required',
            'app_id' => 'required',
            'app_name' => 'required',
            'ussd_code' => 'required',
            'obd_amount' => 'required',
            'audio_clip_id' => 'required',
        ];

        $messages = [
            'schedule_datetime.required' => 'Select Date & Time field is required!',
            'category_id' => 'Category field is required!',
            'app_id.required' => 'App ID field is required!',
            'app_name.required' => 'App Name field is required!',
            'ussd_code.required' => 'USSD Code field is required!',
            'obd_amount.required' => 'OBD Amount field is required!',
            'audio_clip_id.required' => 'OBD Clip field is required!',
        ];

        $this->validate($request, $rules, $messages);

        $schedule_datetime = date('Y-m-d H:i:s', strtotime($request->schedule_datetime));
        $now = date('Y-m-d H:i:s');

        if($now > $schedule_datetime){
            return redirect()->back()->withErrors("Please schedule on a future date!");
        }

        $user_id = session()->get('user_id');
        // $user_credit = UserPack::where('user_id', $user_id)->where('valid_till', '>=', date('Y-m-d H:i:s'))->where('status', 1)->sum('amount');
        // $user_debit = Schedule::where('user_id', $user_id)->sum('obd_amount');
        // $user_remaining = $user_credit-$user_debit;
        $user_remaining = getUserOBDBalance($user_id);

        if($request->obd_amount > $user_remaining){
            return redirect()->back()->withErrors("You do not have sufficient credit. Please buy credit first!");
        }

        $already_obd_scheduled = Schedule::where('schedule_time', 'like', date('Y-m-d', strtotime($request->schedule_datetime)).'%')->sum('obd_amount');
        $remaining_obd_limit = 200000-$already_obd_scheduled;

        if($request->obd_amount > $remaining_obd_limit ){
            return redirect()->back()->withErrors("Daily OBD limit for ".date('d-m-Y', strtotime($request->schedule_datetime))." exceeded. Please try a different date!");
        }

        $scheduleData = new Schedule;
        $scheduleData->user_id = $user_id;
        $scheduleData->category_id = $request->category_id;
        $scheduleData->clip_id = $request->audio_clip_id;
        $scheduleData->app_id = $request->app_id;
        $scheduleData->app_name = $request->app_name;
        $scheduleData->ussd_code = $request->ussd_code;
        $scheduleData->schedule_time = date('Y-m-d H:i:s', strtotime($request->schedule_datetime));
        $scheduleData->obd_amount = $request->obd_amount;
        $scheduleData->save();

        // $user_debit = Schedule::where('user_id', $user_id)->sum('obd_amount');
        // $user_remaining = $user_credit-$user_debit;
        // session()->put('user_credit', $user_remaining);
        $userOBDBalance = getUserOBDBalance($user_id);
        session()->put('user_credit', $userOBDBalance);

        $message = 'Schedule saved successfully! In case of technical difficulties, we will deliver your schedule within 72 hours.';
        $body = "New OBD Schedule has been created!";
        $sendTo = ['asad.zaman@miaki.co','yusuf.shumon@miaki.co','swapon.kumar@miaki.co'];
        \Mail::to($sendTo)->send(new \App\Mail\ScheduleMail($body));
        return redirect()->back()->with('message',$message);
    }

    public function history(Request $request)
    {
        $title = "AdMy | Schedule History";
        $is_active = "schedule_history";
        $categories = Category::where('status', 1)->get();

        // $user_id = session()->get('user_id');
        // $all_schedule_list = Schedule::where('user_id', $user_id)->paginate(10);
        $this->manageSession($request);
        $all_schedule_list = $this->getContentQueryBuilder('single');
        $all_schedule_list = $all_schedule_list->paginate(50);

        return view('portal.schedule.history', compact('title', 'is_active', 'categories', 'all_schedule_list'));
    }

    public function reset() {
        session()->forget('shdaterange');
        session()->forget('shcategory');
        session()->forget('shstatus');
        session()->forget('app_id');
        session()->forget('app_name');
        session()->forget('ussd_code');

        return redirect()->route('schedule.history');
    }

    public function resetList(){
        session()->forget('shdaterange');
        session()->forget('shcategory');
        session()->forget('shstatus');
        session()->forget('app_id');
        session()->forget('app_name');
        session()->forget('ussd_code');

        return redirect()->route('schedule.list');
    }

    public function resetReport(){
      session()->forget('shrdaterange');
      session()->forget('shrcategory');
      session()->forget('shrapp_id');
      session()->forget('shrapp_name');
      session()->forget('shrussd_code');

      return redirect()->route('schedule.report');
  }

    private function manageSession(Request $request){

        $shdaterange = '';
        if( $request->has('shdaterange') ) {
          $shdaterange = $request->shdaterange;
        } elseif( session()->has('shdaterange') ) {
          $shdaterange = session()->get('shdaterange');
        }
        session()->put('shdaterange', $shdaterange);

        $shstatus = '';
        if( $request->has('shstatus') ) {
          $shstatus = $request->shstatus;
        } elseif( session()->has('shstatus') ) {
          $shstatus = session()->get('shstatus');
        }
        session()->put('shstatus', $shstatus);

        $shcategory = '';
        if( $request->has('shcategory') ) {
          $shcategory = $request->shcategory;
        } elseif( session()->has('shcategory') ) {
          $shcategory = session()->get('shcategory');
        }
        session()->put('shcategory', $shcategory);

        $app_id = '';
        if( $request->has('app_id') ) {
          $app_id = $request->app_id;
        } elseif( session()->has('app_id') ) {
          $app_id = session()->get('app_id');
        }
        session()->put('app_id', $app_id);

        $app_name = '';
        if( $request->has('app_name') ) {
          $app_name = $request->app_name;
        } elseif( session()->has('app_name') ) {
          $app_name = session()->get('app_name');
        }
        session()->put('app_name', $app_name);

        $ussd_code = '';
        if( $request->has('ussd_code') ) {
          $ussd_code = $request->ussd_code;
        } elseif( session()->has('ussd_code') ) {
          $ussd_code = session()->get('ussd_code');
        }
        session()->put('ussd_code', $ussd_code);

        return;
    }

    private function manageSessionReport(Request $request){

      $shrdaterange = '';
      if( $request->has('shrdaterange') ) {
        $shrdaterange = $request->shrdaterange;
      } elseif( session()->has('shrdaterange') ) {
        $shrdaterange = session()->get('shrdaterange');
      }
      session()->put('shrdaterange', $shrdaterange);

      $shrcategory = '';
      if( $request->has('shrcategory') ) {
        $shrcategory = $request->shrcategory;
      } elseif( session()->has('shrcategory') ) {
        $shrcategory = session()->get('shrcategory');
      }
      session()->put('shrcategory', $shrcategory);

      $shrapp_id = '';
      if( $request->has('shrapp_id') ) {
        $shrapp_id = $request->shrapp_id;
      } elseif( session()->has('shrapp_id') ) {
        $shrapp_id = session()->get('shrapp_id');
      }
      session()->put('shrapp_id', $shrapp_id);

      $shrapp_name = '';
      if( $request->has('shrapp_name') ) {
        $shrapp_name = $request->shrapp_name;
      } elseif( session()->has('shrapp_name') ) {
        $shrapp_name = session()->get('shrapp_name');
      }
      session()->put('shrapp_name', $shrapp_name);

      $shrussd_code = '';
      if( $request->has('shrussd_code') ) {
        $shrussd_code = $request->shrussd_code;
      } elseif( session()->has('shrussd_code') ) {
        $shrussd_code = session()->get('shrussd_code');
      }
      session()->put('shrussd_code', $shrussd_code);

      return;
  }

    private function getContentQueryBuilder($type){
        $shdaterange = session()->get('shdaterange');
        $shstatus = session()->get('shstatus');
        $shcategory = session()->get('shcategory');
        $app_id = session()->get('app_id');
        $app_name = session()->get('app_name');
        $ussd_code = session()->get('ussd_code');

        if($type == 'single'){
          $user_id = session()->get('user_id');
          $contents = Schedule::where('user_id', $user_id)->orderBy('created_at','desc');
        }else{
          $contents = Schedule::orderBy('created_at','desc');
        }

        if( $shdaterange ) {
            $shdaterange = (explode(" - ", $shdaterange));
            $shfromdate = $shdaterange[0];
            $shtodate = $shdaterange[1];

            $contents = $contents->where('schedule_time', '>=', date('Y-m-d', strtotime($shfromdate)));
            $contents = $contents->where('schedule_time', '<=', date('Y-m-d', strtotime($shtodate . ' +1 day')));
        }
        if( $app_id ) {
          $contents = $contents->where('app_id', 'LIKE', '%'.$app_id.'%');
        }
        if( $app_name ) {
            $contents = $contents->where('app_name', 'LIKE', '%'.$app_name.'%');
        }
        if( $ussd_code ) {
        $contents = $contents->where('ussd_code', 'LIKE', '%'.$ussd_code.'%');
        }
        if( $shcategory ) {
          $contents = $contents->where('category_id', $shcategory);
        }
        if( $shstatus ) {
          $shstatus = $shstatus == 'active' ? 1 : 0;
          $contents = $contents->where('status', $shstatus);
        }
        return $contents;
    }

    private function getContentQueryBuilderReport(){
      $shrdaterange = session()->get('shrdaterange');
      $shrcategory = session()->get('shrcategory');
      $shrapp_id = session()->get('shrapp_id');
      $shrapp_name = session()->get('shrapp_name');
      $shrussd_code = session()->get('shrussd_code');

      $user_id = session()->get('user_id');
      // $contents = Schedule::where('user_id', $user_id)->orderBy('created_at','desc');
      $contents = Report::join('schedules', 'schedules.id', '=', 'reports.schedule_id')
                          ->join('categories', 'categories.id', '=', 'schedules.category_id')
                          ->join('audio_clips', 'audio_clips.id', '=', 'schedules.clip_id')
                          ->where('schedules.user_id', $user_id)
                          ->select('categories.title as category_name', 'audio_clips.title as clip_name', 'schedules.*', 'reports.*')
                          ->orderBy('reports.created_at','desc');

      if( $shrdaterange ) {
          $shrdaterange = (explode(" - ", $shrdaterange));
          $shfromdate = $shrdaterange[0];
          $shtodate = $shrdaterange[1];

          $contents = $contents->where('schedule_time', '>=', date('Y-m-d', strtotime($shfromdate)));
          $contents = $contents->where('schedule_time', '<=', date('Y-m-d', strtotime($shtodate . ' +1 day')));
      }
      if( $shrapp_id ) {
        $contents = $contents->where('app_id', 'LIKE', '%'.$shrapp_id.'%');
      }
      if( $shrapp_name ) {
          $contents = $contents->where('app_name', 'LIKE', '%'.$shrapp_name.'%');
      }
      if( $shrussd_code ) {
      $contents = $contents->where('ussd_code', 'LIKE', '%'.$shrussd_code.'%');
      }
      if( $shrcategory ) {
        $contents = $contents->where('schedules.category_id', $shrcategory);
      }

      return $contents;
  }

    public function list(Request $request)
    {
        $title = "AdMy | Schedule List";
        $is_active = "schedule_list";
        $categories = Category::where('status', 1)->get();

        // $user_id = session()->get('user_id');
        // $all_schedule_list = Schedule::where('user_id', $user_id)->paginate(10);
        $this->manageSession($request);
        $all_schedule_list = $this->getContentQueryBuilder('all');
        $all_schedule_list = $all_schedule_list->paginate(50);

        return view('portal.schedule.list', compact('title', 'is_active', 'categories', 'all_schedule_list'));
    }

    public function update(Request $request){
        $scheduleData = Schedule::where('id', $request->schedule_id)->first();
        $scheduleData->actual_delivery_time = date('Y-m-d H:i:s', strtotime($request->actual_delivery_time));
        $scheduleData->status = 1;
        $scheduleData->save();

        $reportData = new Report;
        $reportData->schedule_id = $request->schedule_id;
        $reportData->sent_amount = $request->sent_amount;
        $reportData->success_amount = $request->success_amount;
        $reportData->failed_amount = $request->failed_amount;
        $reportData->subscribed_amount = $request->subscribed_amount;
        $reportData->save();

        $message = 'Schedule updated successfully!';
        $log_write = storeActivityLog('OBD','OBD Schedule Update',json_encode($request->all()));
        return redirect()->route('schedule.list')->with('message',$message);
    }

    public function report(Request $request){
      $title = "AdMy | Schedule Report";
      $is_active = "schedule_report";
      $categories = Category::where('status', 1)->get();

      // $user_id = session()->get('user_id');
      // $report_data = Report::join('schedules', 'schedules.id', '=', 'reports.schedule_id')
      //                     ->join('categories', 'categories.id', '=', 'schedules.category_id')
      //                     ->join('audio_clips', 'audio_clips.id', '=', 'schedules.clip_id')
      //                     ->where('schedules.user_id', $user_id)
      //                     ->select('categories.title as category_name', 'audio_clips.title as clip_name', 'schedules.*', 'reports.*')
      //                     ->paginate(50);

      $this->manageSessionReport($request);
      $report_data = $this->getContentQueryBuilderReport();
      $report_data = $report_data->paginate(50);
      return view('portal.schedule.report', compact('title', 'is_active', 'categories', 'report_data'));
    }
    public function reject ($id){
      $scheduleData = Schedule::where('id', $id)->first();
      $scheduleData->status = -1; //"-1" means schedule reject 
      $scheduleData->obd_amount = 0; 
      $scheduleData->save();
      
      $user_email = User::where('id',$scheduleData->user_id)->first();
      $message = 'Schedule rejected successfully!';
      $msgString = 'App-'.$scheduleData->app_name.' App Id-'.$scheduleData->app_id.' USSD Code-'.$scheduleData->ussd_code;
      $log_write = storeActivityLog('OBD','OBD Schedule reject',$msgString);
      $body = "Your OBD Schedule has been rejected!".' '.$msgString;
      $sendTo = $user_email->email;
      \Mail::to($sendTo)->send(new \App\Mail\ScheduleRejectMail($body));
      return redirect()->route('schedule.list')->with('message',$message);
    }

}
