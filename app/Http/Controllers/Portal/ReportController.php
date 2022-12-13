<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserPack; // OBD
use App\UserSMS; // SMS
use App\User; // SMS
use App\Models\Log; // Log
use DB;

class ReportController extends Controller
{
    public function dailyUserReport(){
        $title = "AdMy | Daily Report";
        $is_active = "user_list";
        $data = User::select(DB::raw('DATE(created_at) as date'),DB::raw('count(*) as total'))->where('status',1)->groupBy('date')->orderBy('date','DESC')->paginate(20);       
        return view('portal.report.userreport', compact('title','is_active','data'));
    }

    public function dailyObdReport(){
        $title = "AdMy | Daily Report";
        $is_active = "obd_report";
        $data = UserPack::select(DB::raw('DATE(created_at) as date'),DB::raw('count(*) as total'))->where('status',1)->groupBy('date')->orderBy('date','DESC')->paginate(20);       
        return view('portal.report.obdreport', compact('title','is_active','data'));
    }

    public function dailySmsReport(){
        $title = "AdMy | Daily Report";
        $is_active = "sms_report";
        $data = UserSMS::select(DB::raw('DATE(created_at) as date'),DB::raw('count(*) as total'))->where('status',1)->where('is_active',1)->groupBy('date')->orderBy('date','DESC')->paginate(20);       
        return view('portal.report.smsreport', compact('title','is_active','data'));
    }

    public function activityLog(){
        $title = "AdMy | Activity Log";
        $is_active = "log_report";
        $data = Log::select('logs.*','users.email','users.username')->leftJoin('users','users.id','=','logs.user_id')->orderBy('id','DESC')->paginate(5);
        return view('portal.report.activityLog', compact('title','is_active','data'));
    }
}
