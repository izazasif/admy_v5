<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserPack;
use App\Models\Pack;
use App\UserSMS;
use App\SMS;
use App\SMSSchedule;
use App\Models\Schedule;
use Hash;
use DB;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function index(){
        $title = "AdMy | Admin User List";
        $is_active = "admin_list";

        $admin_users = User::where('role', 'admin')->paginate(50);

        return view('portal.admin.list', compact('title', 'is_active', 'admin_users'));
    }

    public function create(){
        $title = "AdMy | Create Admin User";
        $is_active = "admin_create";

        return view('portal.admin.create', compact('title', 'is_active'));
    }

    public function store(Request $request){
      $rules = [
        'username' => 'required',
        'email' => 'required|email',
        'password' => 'required',
        'confirm_password' => 'required',
        'status' => 'required',
        'user_permission' => 'required',
      ];
      
      $messages = [
        'username.required' => 'Username field is required!',
        'email.required' => 'Email field is required!',
        'email.email' => 'Invalid email address!',
        'password.required' => 'Password field is required!',
        'confirm_password.required' => 'Confirm Password field is required!',
        'status.required' => 'Status field is required!',
        'user_permission.required' => 'Permission field is required!',
      ];
      
      $this->validate($request, $rules, $messages);

      if($request->password != $request->confirm_password){
        return redirect()->back()->withErrors("Passwords didn't match!");
      }

      $checkUserData = User::where('email', $request->email)->first();

      if(!empty($checkUserData)){
        return redirect()->back()->withErrors("Email already exists!");
      }

        $userData = new User;
        $userData->username = $request->username;
        $userData->password = Hash::make($request->password);
        $userData->email = $request->email;
        $userData->role = 'admin';
        $userData->is_verified = 1;
        $userData->status = $request->status;
        $userData->permission = $request->user_permission;
        $userData->save(); 
      $log_write = storeActivityLog('Admin','Admin Create',json_encode($request->all()));
      $message = 'Admin user created successfully!';
      return redirect()->route('admin.list')->with('message',$message);
    }

    public function edit($id){
      $title = "AdMy | Edit Admin User";
      $is_active = "admin_edit";

      $adminDetail = User::where('id', $id)->first();

      return view('portal.admin.edit', compact('title', 'is_active', 'adminDetail'));
    }

    public function update(Request $request){
      $rules = [
        'username' => 'required',
        'status' => 'required',
      ];
      
      $messages = [
          'username.required' => 'Username field is required!',
          'status.required' => 'Status field is required!',
      ];
      
      $this->validate($request, $rules, $messages);

      if($request->password){
          if($request->password != $request->confirm_password){
            return redirect()->back()->withErrors("Passwords didn't match!");
          }
      }

      $user_id = $request->user_id;

      $userData = User::where('id', $user_id)->first();
      $userData->username = $request->username;
      if($request->password){
        $userData->password = Hash::make($request->password);
      }
      
      if($request->user_permission){
        $userData->permission = $request->user_permission;
      }
      $userData->status = $request->status;
      $userData->save();

      $message = 'Admin user updated successfully!';
      $log_write = storeActivityLog('Admin','Admin Update',json_encode($request->all()));
      return redirect()->route('admin.list')->with('message',$message);
    }

    public function userList(){
        $title = "AdMy | User List";
        $is_active = "user_list";

        $users = User::where('role', 'user')->paginate(50);

        return view('portal.user.list', compact('title', 'is_active', 'users'));
    }

    public function userUpdateActive($id){
        $userData = User::where('id', $id)->first();
        $userData->status =  1;
        $userData->save();

        $message = 'User status updated successfully!';
        $log_write = storeActivityLog('User','User Update', $userData->username.'-'.$userData->email."User Activate");
        return redirect()->route('user.list')->with('message',$message);
    }

    public function userUpdateInactive($id){
        $userData = User::where('id', $id)->first();
        $userData->status =  0;
        $userData->save();

        $message = 'User status updated successfully!';
        $log_write = storeActivityLog('User','User Update', $userData->username.'-'.$userData->email."User Inctivate");
        return redirect()->route('user.list')->with('message',$message);
    }

    public function dashboard() {

      $is_active = "dashboard_view";
      return view('portal.admin.dashboard',compact('is_active'));
    }

    public function bar_chart()
    {     
      $strat_date = Carbon::today()->format('Y-m-d 00:00:00');
      $end_date  =  Carbon::today()->format('Y-m-d 12:59:59');



      //new register 
      $data['user'] = User::whereBetween('created_at',[$strat_date,$end_date])->count();
        
      //package_sold

      $pack_sms = UserSMS::whereBetween('created_at', [$strat_date,$end_date])->where('payment_status','=',"Completed")->count();
      $pack = UserPack::whereBetween('created_at', [$strat_date,$end_date])->where('status','=',1)->count();
      
      $data['pack_sold1'] = $pack_sms ;
      $data['pack_sold2'] = $pack ;
      $data['package_sold'] = $pack_sms + $pack ;

      //Total_BDT

      $test = DB::table('s_m_s')
                ->select(
                  DB::raw('sum( base_price * ((gateway_charge + vat)/100)) + sum(price) as tot_base'),
                )
                ->join('user_s_m_s', 's_m_s.id', '=', 'user_s_m_s.sms_id')
                ->where('s_m_s.status', '=', 1)
                ->where('user_s_m_s.gateway_charge','!=',null)
                ->whereBetween('user_s_m_s.created_at', [$strat_date, $end_date])
                ->get();
       $purchases = $test[0]->tot_base; 
             

      $pack_pur =  DB::table('packs')
                ->join('user_packs', 'packs.id', '=', 'user_packs.pack_id')
                ->where('packs.status', '=', 1)
                ->whereBetween('packs.created_at', [$strat_date,$end_date])
                ->sum('packs.price');
    $data['total1'] = $purchases;
    $data['total2'] = $pack_pur;          
    $data['total'] = $purchases + $pack_pur;                     

     //Schdeule
      $schdeule_1 = SMSSchedule::whereBetween('created_at', [$strat_date,$end_date])->where('status','=',1)->count();
      $schdeule_2 = Schedule::whereBetween('created_at', [$strat_date,$end_date])->where('status','=',1)->count();
      $data['schdeule'] = $schdeule_1 + $schdeule_2;
 


      //Total_sms_SOLD  
      $data['to_sms'] = DB::table('s_m_s')
                      ->join('user_s_m_s', 's_m_s.id', '=', 'user_s_m_s.sms_id')
                      ->where('s_m_s.status', '=', 1)
                      ->whereBetween('user_s_m_s.created_at', [$strat_date,$end_date])
                      ->sum('s_m_s.amount');
      //Total_OBD_SOLD 
      $data['to_odb'] = DB::table('packs')
                      ->join('user_packs', 'packs.id', '=', 'user_packs.pack_id')
                      ->where('packs.status', '=', 1)
                      ->whereBetween('user_packs.created_at', [$strat_date,$end_date])
                      ->sum('packs.amount');
        
           // Bar chart _sms
           $data['today_sells_1']  = DB::table('s_m_s')
                                  ->join('user_s_m_s', 's_m_s.id', '=', 'user_s_m_s.sms_id')
                                  ->where('s_m_s.status','=',1)
                                  ->whereBetween('user_s_m_s.created_at', [$strat_date,$end_date])
                                  ->sum('s_m_s.price');

           $data['today_sells_2']  = DB::table('s_m_s')
                                  ->join('user_s_m_s', 's_m_s.id', '=', 'user_s_m_s.sms_id')
                                  ->where('s_m_s.status','=',1)
                                  ->whereDate('user_s_m_s.created_at',[Carbon::yesterday()])
                                  ->sum('s_m_s.price');

       
          $data['today_sells_3'] = DB::table('s_m_s')
                                  ->join('user_s_m_s', 's_m_s.id', '=', 'user_s_m_s.sms_id')
                                  ->where('s_m_s.status','=',1)
                                  ->whereDate('user_s_m_s.created_at',[Carbon::today()->subDays(2)->format('Y-m-d H:i:s')])
                                  ->sum('s_m_s.price');

           $data['today_sells_4'] = DB::table('s_m_s')
                                  ->join('user_s_m_s', 's_m_s.id', '=', 'user_s_m_s.sms_id')
                                  ->where('s_m_s.status','=',1)
                                  ->whereDate('user_s_m_s.created_at',[Carbon::today()->subDays(3)->format('Y-m-d H:i:s')])
                                  ->sum('s_m_s.price');
           $data['today_sells_5']  = DB::table('s_m_s')
                                  ->join('user_s_m_s', 's_m_s.id', '=', 'user_s_m_s.sms_id')
                                  ->where('s_m_s.status','=',1)
                                  ->whereDate('user_s_m_s.created_at',[Carbon::today()->subDays(4)->format('Y-m-d H:i:s')])
                                  ->sum('s_m_s.price');
           $data['today_sells_6']  = DB::table('s_m_s')
                                  ->join('user_s_m_s', 's_m_s.id', '=', 'user_s_m_s.sms_id')
                                  ->where('s_m_s.status','=',1)
                                  ->whereDate('user_s_m_s.created_at',[Carbon::today()->subDays(5)->format('Y-m-d H:i:s')])
                                  ->sum('s_m_s.price');
         $data['today_sells_7'] = DB::table('s_m_s')
                                ->join('user_s_m_s', 's_m_s.id', '=', 'user_s_m_s.sms_id')
                                ->where('s_m_s.status','=',1)
                                ->whereDate('user_s_m_s.created_at',[Carbon::today()->subDays(6)->format('Y-m-d H:i:s')])
                                ->sum('s_m_s.price');
           // Bar chart _obd
           $data['today_sells_obd_1']  = DB::table('packs')
                                ->join('user_packs', 'packs.id', '=', 'user_packs.pack_id')
                                ->where('packs.status','=',1)
                                ->whereDate('user_packs.created_at', [Carbon::today()])
                                ->sum('packs.price');
           $data['today_sells_obd_2']  = DB::table('packs')
                                  ->join('user_packs', 'packs.id', '=', 'user_packs.pack_id')
                                  ->where('packs.status','=',1)
                                  ->whereDate('user_packs.created_at',[Carbon::yesterday()])
                                  ->sum('packs.price');
                    
           $data['today_sells_obd_3']  = DB::table('packs')
                                  ->join('user_packs', 'packs.id', '=', 'user_packs.pack_id')
                                  ->where('packs.status','=',1)
                                  ->whereDate('user_packs.created_at',[Carbon::today()->subDays(2)->format('Y-m-d H:i:s')])
                                  ->sum('packs.price');
           
           $data['today_sells_obd_4'] = DB::table('packs')
                                ->join('user_packs', 'packs.id', '=', 'user_packs.pack_id')
                                ->where('packs.status','=',1)
                                ->whereDate('user_packs.created_at',[Carbon::today()->subDays(3)->format('Y-m-d H:i:s')])
                                ->sum('packs.price');
           $data['today_sells_obd_5']  = DB::table('packs')
                                ->join('user_packs', 'packs.id', '=', 'user_packs.pack_id')
                                ->where('packs.status','=',1)
                                ->whereDate('user_packs.created_at',[Carbon::today()->subDays(4)->format('Y-m-d H:i:s')])
                                ->sum('packs.price');
           $data['today_sells_obd_6']  = DB::table('packs')
                                ->join('user_packs', 'packs.id', '=', 'user_packs.pack_id')
                                ->where('packs.status','=',1)
                                ->whereDate('user_packs.created_at',[Carbon::today()->subDays(5)->format('Y-m-d H:i:s')])
                                ->sum('packs.price');
         $data['today_sells_obd_7'] = DB::table('packs')
                                ->join('user_packs', 'packs.id', '=', 'user_packs.pack_id')
                                ->where('packs.status','=',1)
                                ->whereDate('user_packs.created_at',[Carbon::today()->subDays(6)->format('Y-m-d H:i:s')])
                                ->sum('packs.price');

          return response()->json($data);   
    }
    
    public function get_data($tm_period)
    {   
         $data = [];
     
         $strat_date = Carbon::today()->format('Y-m-d 00:00:00');
         $end_date  =  Carbon::today()->format('Y-m-d 12:59:59');
        
         if($tm_period== "daily"){

          //new register 
          $data['user'] = User::whereBetween('created_at',[$strat_date,$end_date])->count();
        
          //package_sold

          $pack_sms = UserSMS::whereBetween('created_at', [$strat_date,$end_date])->where('payment_status','=',"Completed")->count();
          $pack = UserPack::whereBetween('created_at', [$strat_date,$end_date])->where('status','=',1)->count();
          
          $data['pack_sold1'] = $pack_sms ;
          $data['pack_sold2'] = $pack ;
          $data['package_sold'] = $pack_sms + $pack ;

          //Total_BDT

           //Total_BDT
           $test = DB::table('s_m_s')
                ->select(
                  DB::raw('sum( base_price * ((gateway_charge + vat)/100)) + sum(price) as tot_base'),
                )
                ->join('user_s_m_s', 's_m_s.id', '=', 'user_s_m_s.sms_id')
                ->where('s_m_s.status', '=', 1)
                ->where('user_s_m_s.gateway_charge','!=',null)
                ->whereBetween('user_s_m_s.created_at', [$strat_date, $end_date])
                ->get();
       $purchases = $test[0]->tot_base;          
       

       
      $pack_pur =  DB::table('packs')
                    ->join('user_packs', 'packs.id', '=', 'user_packs.pack_id')
                    ->where('packs.status', '=', 1)
                    ->whereBetween('packs.created_at', [$strat_date,$end_date])
                    ->sum('packs.price');
       $data['total1'] = $purchases;
       $data['total2'] = $pack_pur;          
       $data['total'] = $purchases + $pack_pur;                     

         //Schdeule
          $schdeule_1 = SMSSchedule::whereBetween('created_at', [$strat_date,$end_date])->where('status','=',1)->count();
          $schdeule_2 = Schedule::whereBetween('created_at', [$strat_date,$end_date])->where('status','=',1)->count();
          $data['schdeule'] = $schdeule_1 + $schdeule_2;
          

          //Total_sms_SOLD  
          $data['to_sms'] = DB::table('s_m_s')
                          ->join('user_s_m_s', 's_m_s.id', '=', 'user_s_m_s.sms_id')
                          ->where('s_m_s.status', '=', 1)
                          ->whereBetween('user_s_m_s.created_at', [$strat_date,$end_date])
                          ->sum('s_m_s.amount');
          //Total_OBD_SOLD 
          $data['to_odb'] = DB::table('packs')
                          ->join('user_packs', 'packs.id', '=', 'user_packs.pack_id')
                          ->where('packs.status', '=', 1)
                          ->whereBetween('user_packs.created_at', [$strat_date,$end_date])
                          ->sum('packs.amount');
                                  
          self::bar_chart();
         }
         if ($tm_period == "weekly")
         {

          $today = Carbon::today()->format('Y-m-d 00:00:00');
          $lastSevenDays = Carbon::today()->subDays(7)->format('Y-m-d 12:59:59');
          

       
           
          //new register 
          $data['user'] = User::whereBetween('created_at', [$lastSevenDays, $today])->count();
          
          
          //Package_sold

          $pack_sms = UserSMS::whereBetween('created_at', [$lastSevenDays, $today])->where('payment_status','=',"Completed")->count();
          $pack = UserPack::whereBetween('created_at', [$lastSevenDays, $today])->where('status','=',1)->count();
          
          $data['pack_sold1'] = $pack_sms ;
          $data['pack_sold2'] = $pack ;
          $data['package_sold'] = $pack_sms + $pack ;
          

              
          //Total_BDT
          $test = DB::table('s_m_s')
                  ->select(
                    
                    DB::raw('sum( base_price * ((gateway_charge + vat)/100)) + sum(price) as tot_base'),
                  )
                  ->join('user_s_m_s', 's_m_s.id', '=', 'user_s_m_s.sms_id')
              ->where('s_m_s.status', '=', 1)
              ->where('user_s_m_s.gateway_charge','!=',null)
              ->whereBetween('user_s_m_s.created_at', [$lastSevenDays, $today])
              ->get();


          
          $purchases = $test[0]->tot_base;
           
         
         
          $pack_pur =  DB::table('packs')
                    ->join('user_packs', 'packs.id', '=', 'user_packs.pack_id')
                    ->where('packs.status', '=', 1)
                    ->whereBetween('packs.created_at', [$lastSevenDays, $today])
                    ->sum('packs.price');
          $data['total1'] = $purchases;
          $data['total2'] = $pack_pur;
          $data['total'] = $purchases + $pack_pur;

          //schdeule

          $schdeule_1 = SMSSchedule::whereBetween('created_at', [$lastSevenDays, $today])->where('status','=',1)->count();
          $schdeule_2 = Schedule::whereBetween('created_at', [$lastSevenDays, $today])->where('status','=',1)->count();
          $data['schdeule'] = $schdeule_1 + $schdeule_2;

          
          //Total_sms_SOLD
          $data['to_sms'] = DB::table('s_m_s')
                          ->join('user_s_m_s', 's_m_s.id', '=', 'user_s_m_s.sms_id')
                          ->where('s_m_s.status', '=', 1)
                          ->whereBetween('user_s_m_s.created_at',[$lastSevenDays, $today])
                          ->sum('s_m_s.amount');
           //Total_obd_SOLD               
          $data['to_odb'] = DB::table('packs')
                          ->join('user_packs', 'packs.id', '=', 'user_packs.pack_id')
                          ->where('packs.status', '=', 1)
                          ->whereBetween('user_packs.created_at',[$lastSevenDays, $today])
                          ->sum('packs.amount');

         }
         if($tm_period == "monthly")
         {
            //new register
           $today = Carbon::today()->format('Y-m-d 00:00:00');
          $month = Carbon::today()->subDays(30)->format('Y-m-d 12:59:59');

          $data['user'] = User::whereBetween('created_at', [$month,$today])->count();

        //Package_sold

          $pack_sms = UserSMS::whereBetween('created_at', [$month,$today])->where('payment_status','=',"Completed")->count();
          $pack = UserPack::whereBetween('created_at', [$month,$today])->where('status','=',1)->count();
          
          $data['pack_sold1'] = $pack_sms ;
          $data['pack_sold2'] = $pack ;
          $data['package_sold'] = $pack_sms + $pack ;

          $check_1 = DB::table('s_m_s')
                    ->join('user_s_m_s', 's_m_s.id', '=', 'user_s_m_s.sms_id')
                    ->where('s_m_s.status', '=', 1)
                    ->whereBetween('s_m_s.created_at', [$month,$today])
                    ->get();
                    
         
          //Total_BDT
          $test = DB::table('s_m_s')
                  ->select(
                    
                    DB::raw('sum( base_price * ((gateway_charge + vat)/100)) + sum(price) as tot_base'),
                  )
                  ->join('user_s_m_s', 's_m_s.id', '=', 'user_s_m_s.sms_id')
              ->where('s_m_s.status', '=', 1)
              ->where('user_s_m_s.gateway_charge','!=',null)
              ->whereBetween('user_s_m_s.created_at', [$month, $today])
              ->get();


          
          $purchases = $test[0]->tot_base;
         
          $pack_pur =  DB::table('packs')
                    ->join('user_packs', 'packs.id', '=', 'user_packs.pack_id')
                    ->where('packs.status', '=', 1)
                    ->whereBetween('packs.created_at', [$month,$today])
                    ->sum('packs.price');
          $data['total1'] = $purchases;
          $data['total2'] = $pack_pur;
          $data['total'] = $purchases + $pack_pur;
        

          //schdeule
          $schdeule_1 = SMSSchedule::whereBetween('created_at', [$month,$today])->where('status','=',1)->count();
          $schdeule_2 = Schedule::whereBetween('created_at', [$month,$today])->where('status','=',1)->count();
          $data['schdeule'] = $schdeule_1 + $schdeule_2;
          
         
            //Total_sms_SOLD
          $data['to_sms'] = DB::table('s_m_s')
                        ->join('user_s_m_s', 's_m_s.id', '=', 'user_s_m_s.sms_id')
                        ->where('s_m_s.status', '=', 1)
                        ->whereBetween('user_s_m_s.created_at', [$month,$today])
                        ->sum('s_m_s.amount');
         //Total_obd_SOLD 
        $data['to_odb'] = DB::table('packs')
                        ->join('user_packs', 'packs.id', '=', 'user_packs.pack_id')
                        ->where('packs.status', '=', 1)
                        ->whereBetween('user_packs.created_at', [$month,$today])
                        ->sum('packs.amount'); 
             
         }
         return response()->json($data); 
    }

    // code added by Tnvr1
    public function get_dashboard_data($tm_period)
    {
        $data = [];  

        if($tm_period== "daily"){
          $strat_date = Carbon::today()->format('Y-m-d 00:00:00');
          $end_date  =  Carbon::today()->format('Y-m-d 23:59:59');
        }
        
        if($tm_period== "weekly"){
          $strat_date = Carbon::today()->format('Y-m-d 23:59:59');
          $end_date  =  Carbon::today()->subDays(7)->format('Y-m-d 00:00:00');
        }
        
        if($tm_period== "monthly"){
          $strat_date = Carbon::today()->format('Y-m-d 23:59:59');
          $end_date  =  Carbon::today()->subMonth()->format('Y-m-d 00:00:00');
        }

        //user count
        $data['user'] = User::whereBetween('created_at', [$strat_date, $end_date])->count();

        //all pkg sold count
        $data['push_sms_sold'] = UserSMS::whereBetween('created_at', [$strat_date,$end_date])->where('payment_status','=',"Completed")->count();
        $data['obd_sold'] = UserPack::whereBetween('created_at', [$strat_date,$end_date])->where('status','=',1)->count();

        //all sum price(bdt) 
        $data['obd_price'] = DB::table('packs')
                            ->join('user_packs', 'packs.id', '=', 'user_packs.pack_id')
                            ->where('user_packs.status', '=', 1)
                            ->whereBetween('user_packs.created_at', [$strat_date, $end_date])
                            ->sum('packs.price'); 

        $push_sms_price_vat = DB::table('user_s_m_s')
                          ->select(DB::raw('sum( base_price + (base_price * ((gateway_charge + vat)/100))) as price_with_vat'))
                          ->where('status', 1)
                          ->whereNotNull('base_price')
                          ->whereBetween('created_at', [$strat_date, $end_date])
                          ->value('price_with_vat');

        $push_sms_price = DB::table('s_m_s')
                          ->join('user_s_m_s', 's_m_s.id', '=', 'user_s_m_s.sms_id')
                          ->where('user_s_m_s.status', 1)
                          ->whereNull('user_s_m_s.base_price')
                          ->whereBetween('user_s_m_s.created_at', [$strat_date, $end_date])
                          ->sum('s_m_s.price');
        
        $data['sms_price'] = $push_sms_price;
        if($push_sms_price_vat != null){
          $data['sms_price'] = $push_sms_price + $push_sms_price_vat; 
        } 
        
        //all schedule count
        $data['sms_schdeule'] = SMSSchedule::whereBetween('created_at', [$strat_date,$end_date])->where('status', 1)->count();
        $data['obd_schdeule'] = Schedule::whereBetween('created_at', [$strat_date,$end_date])->where('status', 1)->count();
        
        //all credit count
        $data['sms_credit'] = DB::table('user_s_m_s')
                            ->where('status', 1)
                            ->whereBetween('created_at', [$strat_date,$end_date])
                            ->sum('amount');

        $data['obd_credit'] = DB::table('user_packs')
                            ->where('status', 1)
                            ->whereBetween('created_at', [$strat_date,$end_date])
                            ->sum('amount');

        $bar_chart = self::bar_chart_data();
        return response()->json($data); 
    }

    public static function obd_price_calculation($start_date,$end_date){
      return DB::table('packs')
                ->join('user_packs', 'packs.id', '=', 'user_packs.pack_id')
                ->where('user_packs.status',1)
                ->whereBetween('user_packs.created_at', [$start_date, $end_date])
                ->sum('packs.price');
    }

    public static function push_sms_price_calculation($start_date,$end_date){
      $push_sms_price_vat = DB::table('user_s_m_s')
                          ->select(DB::raw('sum( base_price + (base_price * ((gateway_charge + vat)/100))) as price_with_vat'))
                          ->where('status', 1)
                          ->whereNotNull('base_price')
                          ->whereBetween('created_at', [$start_date, $end_date])
                          ->value('price_with_vat');

      $push_sms_price = DB::table('s_m_s')
                          ->join('user_s_m_s', 's_m_s.id', '=', 'user_s_m_s.sms_id')
                          ->where('user_s_m_s.status', 1)
                          ->whereNull('user_s_m_s.base_price')
                          ->whereBetween('user_s_m_s.created_at', [$start_date, $end_date])
                          ->sum('s_m_s.price');
        
      if($push_sms_price_vat != null){
        return $push_sms_price + $push_sms_price_vat; 
      }

      return $push_sms_price;
    }

    public static function bar_chart_data(){

      $data=[];      

      //obd data
      $data['obd_1'] = self::obd_price_calculation(Carbon::today()->format('Y-m-d 00:00:00'),Carbon::today()->format('Y-m-d 23:59:59'));
      $data['obd_2'] = self::obd_price_calculation(Carbon::yesterday()->format('Y-m-d 00:00:00'),Carbon::yesterday()->format('Y-m-d 23:59:59'));
      $data['obd_3'] = self::obd_price_calculation(Carbon::today()->subDays(2)->format('Y-m-d 00:00:00'),Carbon::today()->subDays(2)->format('Y-m-d 23:59:59'));
      $data['obd_4'] = self::obd_price_calculation(Carbon::today()->subDays(3)->format('Y-m-d 00:00:00'),Carbon::today()->subDays(3)->format('Y-m-d 23:59:59'));
      $data['obd_5'] = self::obd_price_calculation(Carbon::today()->subDays(4)->format('Y-m-d 00:00:00'),Carbon::today()->subDays(4)->format('Y-m-d 23:59:59'));
      $data['obd_6'] = self::obd_price_calculation(Carbon::today()->subDays(5)->format('Y-m-d 00:00:00'),Carbon::today()->subDays(5)->format('Y-m-d 23:59:59'));
      $data['obd_7'] = self::obd_price_calculation(Carbon::today()->subDays(6)->format('Y-m-d 00:00:00'),Carbon::today()->subDays(6)->format('Y-m-d 23:59:59'));
      
      //push sms data
      $data['push_sms_1'] = self::push_sms_price_calculation(Carbon::today()->format('Y-m-d 00:00:00'),Carbon::today()->format('Y-m-d 23:59:59'));
      $data['push_sms_2'] = self::push_sms_price_calculation(Carbon::yesterday()->format('Y-m-d 00:00:00'),Carbon::yesterday()->format('Y-m-d 23:59:59'));
      $data['push_sms_3'] = self::push_sms_price_calculation(Carbon::today()->subDays(2)->format('Y-m-d 00:00:00'),Carbon::today()->subDays(2)->format('Y-m-d 23:59:59'));
      $data['push_sms_4'] = self::push_sms_price_calculation(Carbon::today()->subDays(3)->format('Y-m-d 00:00:00'),Carbon::today()->subDays(3)->format('Y-m-d 23:59:59'));
      $data['push_sms_5'] = self::push_sms_price_calculation(Carbon::today()->subDays(4)->format('Y-m-d 00:00:00'),Carbon::today()->subDays(4)->format('Y-m-d 23:59:59'));
      $data['push_sms_6'] = self::push_sms_price_calculation(Carbon::today()->subDays(5)->format('Y-m-d 00:00:00'),Carbon::today()->subDays(5)->format('Y-m-d 23:59:59'));
      $data['push_sms_7'] = self::push_sms_price_calculation(Carbon::today()->subDays(6)->format('Y-m-d 00:00:00'),Carbon::today()->subDays(6)->format('Y-m-d 23:59:59'));

      //get last 7 date
      $data['date_1'] = Carbon::today()->format('d-m-Y');
      $data['date_2'] = Carbon::yesterday()->format('d-m-Y');
      $data['date_3'] = Carbon::today()->subDays(2)->format('d-m-Y');
      $data['date_4'] = Carbon::today()->subDays(3)->format('d-m-Y');
      $data['date_5'] = Carbon::today()->subDays(4)->format('d-m-Y');
      $data['date_6'] = Carbon::today()->subDays(5)->format('d-m-Y');
      $data['date_7'] = Carbon::today()->subDays(6)->format('d-m-Y');

      return $data;

    } 

}
