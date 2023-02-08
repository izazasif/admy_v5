<?php

namespace App\Http\Controllers;
use App\SMSSchedule;
use App\Models\Schedule;
use App\UserSMS;
use App\SMS;
use App\Models\Report;
use Illuminate\Http\Request;
use App\Models\User;
use DB;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        $daterange = $request->search_date;
        

        if($daterange){
            session()->put('search_date', $daterange);
            $f = trim(explode("-",$daterange)[0]," ");
            $t = trim(explode("-",$daterange)[1]," ");
            $from = \Carbon\Carbon::createFromFormat('m/d/Y', $f)->format('Y-m-d'.' 00:00:00');
            $to = \Carbon\Carbon::createFromFormat('m/d/Y', $t)->format('Y-m-d'.' 23:59:59');
            $user_total = User::select(DB::raw("DATE(created_at) as date"), DB::raw("count(*) as total"))
                                     ->whereBetween('created_at',[$from, $to])
                                     ->groupBy(DB::raw("DATE(created_at)"))
                                     ->get();
                                                             
            $total_1 = 0;
            
            foreach ($user_total as $result) {
        
            $total_1 += $result->total;
           }
                                      
        }
        else {
            $total_1 = 0;  
            $user_total = [];
        }
        
        $title = "AdMy | Report User";
        $is_active = "user_report";

        return view('portal.report_obd.user_report', compact('title', 'is_active','user_total','total_1'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function schedule(Request $request)
    {
        $title = "AdMy | Report User";
        $is_active = "schedule_report";

        $daterange = $request->shdaterange;

        if($daterange){
            session()->put('search_date_schedule', $daterange);
            $f = trim(explode("-",$daterange)[0]," ");
            $t = trim(explode("-",$daterange)[1]," ");
            $from = \Carbon\Carbon::createFromFormat('m/d/Y', $f)->format('Y-m-d'.' 00:00:00');
            $to = \Carbon\Carbon::createFromFormat('m/d/Y', $t)->format('Y-m-d'.' 23:59:59');
            $appends = ['sms'];
            $schedule_total_sms = SMSSchedule::select(DB::raw("DATE(created_at) as date"), DB::raw("sum(sms_amount) as total"),DB::raw('("My Push") as type'),'app_id','app_name')
                                     ->whereBetween('created_at',[$from, $to])
                                     ->groupBy(DB::raw("DATE(created_at)"),'app_id','app_name')
                                     ->get();
            $schedule_total_obd = Schedule::select(DB::raw("DATE(created_at) as date"), DB::raw("sum(obd_amount) as total"),DB::raw('("OBD") as type'),'app_id','app_name')
                                     ->whereBetween('created_at',[$from, $to])
                                     ->groupBy(DB::raw("DATE(created_at)"),'app_id','app_name')
                                     ->get();

    foreach($schedule_total_sms as $tot_sms) {
        $schedule_total_obd->add($tot_sms);
    }
    $schedule_total_obd1 = $schedule_total_obd->sortBy('date');

        $total_1 = 0;
        foreach ($schedule_total_obd1 as $result) {
        
              $total_1 += $result->total;
           }                                                 
      }
       else {
            $total_1 = 0;
            $schedule_total_obd1 = [];
           }
        return view('portal.report_obd.schedule_report', compact('title', 'is_active','schedule_total_obd1','total_1'));
    }

    public function  package(Request $request)
    {
        $daterange = $request->shdaterange;
        

        if($daterange){
            session()->put('search_date_package', $daterange);
            $f = trim(explode("-",$daterange)[0]," ");
            $t = trim(explode("-",$daterange)[1]," ");
            $from = \Carbon\Carbon::createFromFormat('m/d/Y', $f)->format('Y-m-d'.' 00:00:00');
            $to = \Carbon\Carbon::createFromFormat('m/d/Y', $t)->format('Y-m-d'.' 23:59:59');
            
            
            $push_sms_sold = DB::table('user_s_m_s')
                            ->join('s_m_s', 's_m_s.id', '=', 'user_s_m_s.sms_id')
                             ->select(DB::raw("sum(tbl_s_m_s.price) as total"),DB::raw( "DATE(tbl_user_s_m_s.created_at) as date"),DB::raw( "sum(tbl_user_s_m_s.amount) as tot_amount"),DB::raw('("My Push") as type'))
                             ->where('user_s_m_s.status', 1)
                            ->where('user_s_m_s.is_active', 1)
                            ->whereBetween('user_s_m_s.created_at',[$from, $to])
                            ->groupBy('date')
                            ->get();
            $obd_sold = DB::table('user_packs')
                            ->join('packs', 'packs.id', '=', 'user_packs.pack_id')
                             ->select(DB::raw("sum(tbl_packs.price) as total"),DB::raw( "DATE(tbl_user_packs.created_at) as date"),DB::raw( "sum(tbl_user_packs.amount) as tot_amount"),DB::raw('("OBD") as type'))
                             ->where('user_packs.status', 1)
                            ->whereBetween('user_packs.created_at',[$from, $to])
                            ->groupBy('date')
                            ->get();                
            
          foreach($push_sms_sold as $tot_sms_sold) {
                  $obd_sold->add($tot_sms_sold);
              }
            $total_package_sold = $obd_sold->sortBy('date');

            $total_1 = 0;
            $total_2 = 0;
         foreach ($total_package_sold as $result) {
            $total_1 += $result->total;
         }
          
         foreach ($total_package_sold as $result) {
            $total_2 += $result->tot_amount;
         }
                                      
        }
        else {
            $total_1 = 0;
            $total_2 = 0;  
            $total_package_sold = [];
        }
        
        $title = "AdMy | Report User";
        $is_active = "package_report";

        return view('portal.report_obd.package_sold', compact('title', 'is_active','total_package_sold','total_1','total_2'));
    }

    public function  obd_report(Request $request)
    {
        $daterange = $request->shdaterange;
        

        if($daterange){
            session()->put('search_date_obd', $daterange);
            $f = trim(explode("-",$daterange)[0]," ");
            $t = trim(explode("-",$daterange)[1]," ");
            $from = \Carbon\Carbon::createFromFormat('m/d/Y', $f)->format('Y-m-d'.' 00:00:00');
            $to = \Carbon\Carbon::createFromFormat('m/d/Y', $t)->format('Y-m-d'.' 23:59:59');
            $all_schedule_list = Schedule::leftjoin('reports', 'schedules.id', '=', 'reports.schedule_id')
                                        ->leftjoin('categories', 'categories.id', '=', 'schedules.category_id')
                                        ->leftjoin('audio_clips', 'audio_clips.id', '=', 'schedules.clip_id')
                                        ->whereBetween('schedules.schedule_time',[$from, $to])
                                        ->select('categories.title as category_name', 'audio_clips.title as clip_name','reports.*','schedules.*')
                                        ->get();
            dd($all_schedule_list);
        }
        else {
            
            $all_schedule_list = [];
        }
        
        $title = "AdMy | Report User";
        $is_active = "obd_report_count";

        return view('portal.report_obd.obd_report', compact('title', 'is_active','all_schedule_list'));
    }  

    public function report_reset_user(){
        session()->forget('search_date');
        // return redirect()->route('report.user');
        return redirect()->back();
    }
    public function report_reset_package(){
        session()->forget('search_date_package');
        return redirect()->back();
    }
    public function report_reset_schedule(){
        session()->forget('search_date_schedule');
        return redirect()->back();
    }
    
    public function reset_obd_report(){
        session()->forget('search_date_obd');
        return redirect()->back();
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
