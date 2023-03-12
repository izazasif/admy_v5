<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Api\CampainController;
use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\SMS;
use App\SMSSchedule;
use App\UserSMS;
use App\Models\User;
use Illuminate\Http\Request;
use PDF;

class SMSController extends Controller
{
    public function index(){
        $sms = SMS::paginate();
        $is_active = 'sms_list';
        return view('portal.sms.index',compact('sms','is_active'));
    }

    public function create(){
        $is_active = 'sms_create';
        return view('portal.sms.create',compact('is_active'));
    }

    public function store(Request $request){
        $rules = [
            'name'          => 'required',
            'sms_category'  => 'required',
            'sms_type'      => 'required',
            'unit_price'    => 'required',
            'price'         => 'required',
            'amount'        => 'required',
            'validity'      => 'required',
            'status'        => 'required',
        ];

        $messages = [
            'name.required'         => 'Name field is required!',
            'name.sms_category'     => 'SMS Category field is required!',
            'name.sms_type'         => 'SMS Type field is required!',
            'unit_price.required'   => 'Unit Price field is required!',
            'price.required'        => 'Total Price field is required!',
            'amount.required'       => 'Amount field is required!',
            'validity.required'     => 'Validity field is required!',
            'status.required'       => 'Status field is required!',
        ];

        $this->validate($request, $rules, $messages);

        $smsData = new SMS();
        $smsData->name = $request->name;
        $smsData->sms_category = $request->sms_category;
        $smsData->sms_type = $request->sms_type;
        $smsData->unit_price = $request->unit_price;
        $smsData->price = $request->price;
        $smsData->amount = $request->amount;
        $smsData->validity = $request->validity;
        $smsData->status = $request->status;
        $smsData->save();

        $message = 'SMS Package Created Successfully!';
        $log_write = storeActivityLog('SMS','SMS Package Created',json_encode($request->all()));
        return redirect()->route('portal.sms.list')->with('message',$message);
    }

    public function edit($id){
        $title = "MyBdApps | Edit SMS Package";
        $is_active = "sms_edit";
        $smsDetail = SMS::where('id', $id)->first();
        return view('portal.sms.edit', compact('title', 'is_active', 'smsDetail'));
    }

    public function update(Request $request){
        $rules = [
            'name'          => 'required',
            'sms_category'  => 'required',
            'sms_type'      => 'required',
            'unit_price'    => 'required',
            'price'         => 'required',
            'amount'        => 'required',
            'validity'      => 'required',
            'status'        => 'required',
        ];

        $messages = [
            'name.required'         => 'Name field is required!',
            'name.sms_category'     => 'SMS Category field is required!',
            'name.sms_type'         => 'SMS Type field is required!',
            'unit_price.required'   => 'Unit Price field is required!',
            'price.required'        => 'Total Price field is required!',
            'amount.required'       => 'Amount field is required!',
            'validity.required'     => 'Validity field is required!',
            'status.required'       => 'Status field is required!',
        ];

        $this->validate($request, $rules, $messages);

        $sms_id = $request->sms_id;

        $smsData = SMS::where('id', $sms_id)->first();
        $smsData->name = $request->name;
        $smsData->sms_category = $request->sms_category;
        $smsData->sms_type = $request->sms_type;
        $smsData->unit_price = $request->unit_price;
        $smsData->price = $request->price;
        $smsData->amount = $request->amount;
        $smsData->validity = $request->validity;
        $smsData->status = $request->status;
        $smsData->save();

        $message = 'SMS Package Updated Successfully!';
        $log_write = storeActivityLog('SMS','SMS Package Updated',json_encode($request->all()));
        return redirect()->route('portal.sms.list')->with('message',$message);
    }

    public function purchase(){
        $title = "MyBdApps | SMS Purchase";
        $is_active = "purchase_sms";
        $sms = SMS::where('status', 1)->get();
        return view('portal.sms.purchase', compact('title', 'is_active', 'sms'));
    }

    public function checkout($id){
        $title = "MyBdApps | SMS Checkout";
        $is_active = "purchase_sms";
        $packDetails = SMS::where('id', $id)->where('status', 1)->first();
            $user_id = session()->get('user_id');
            $userPackData = new UserSMS();
            $userPackData->user_id = $user_id;
            $userPackData->sms_id = $id;
            $userPackData->amount = $packDetails->amount;
            $userPackData->base_price = $packDetails->price;
            $userPackData->vat = env('APP_PSMS_VAT'); // percentage
            $userPackData->gateway_charge = env('APP_PSMS_GATEWAY'); // percentage
            $userPackData->channel = 'push';
            $userPackData->is_active = 0;
            $userPackData->payment_status = 'Pending';
            $userPackData->type = 'bkash';
            $userPackData->valid_till = date('Y-m-d H:i:s', strtotime(now() . ' +' . $packDetails->validity . ' day'));
            $success = $userPackData->save();
            if($success) {
                $user_pack_id = $userPackData->id;
                $bkash = new BikashController();
                $token = $bkash->getToken();
                if($token == -1){
                    return back();
                }
                session()->put('bkash_token',$token);
                $total_amount = $packDetails->price + ($packDetails->price * ((env('APP_PSMS_VAT')+env('APP_PSMS_GATEWAY')) / 100));
                return view('portal.sms.checkout', compact('title', 'is_active', 'packDetails','user_pack_id','total_amount'));
            }else{
                $message = 'Something is wrong, try again';
                return redirect()->back()->with('message',$message);
            }
    }

    public function startCampaign($id){
        $user_id = session()->get('user_id');
        $schedule = SMSSchedule::where('id', $id)->first();
        if($schedule){
            $campaign = new CampainController();
           $response =  $campaign->createCampaign($schedule->user_id,$schedule->id);
           if ($response && $response->result==0){
               $cpgn = new Campaign();
               $cpgn->campaign_id = $response->campaign_id;
               $cpgn->schedule_id = $schedule->id;
               $cpgn->user_id     = $schedule->user_id;
               $cpgn->app_id      = $schedule->app_id;
               $cpgn->conversions = $schedule->sms_amount;
               $cpgn->status      = 'CREATED';
               $cpgn->save();
               $schedule->status = 1;
               $schedule->save();
               $message = "Campaign has created successfully, campaign id: ".$response->campaign_id;
               $text = "campaign-id =".$response->campaign_id .", app-id=".$schedule->app_id.", SMS amount=".$schedule->sms_amount.", user-id=".$schedule->user_id;
               $log_write = storeActivityLog('SMS','SMS Campaign Create',$text);
           }elseif($response && $response->result==1){
               $message = "No balance remaining in purchased packages for specified channel";
           }else{
               $message = "Somethings is wrong";
           }
        }else{
            $message = "Invalid Schedule";
        }
        return redirect()->back()->with('message',$message);
    }

    public function campaignInformation($id){
        $title = "MyBdApps | Campaign Stat";
        $is_active = "campaign_stat";
        $cam = Campaign::where('schedule_id',$id)->select('campaign_id')->first();
        $campaign = new CampainController();
        $response =  $campaign->getCampainInformation($cam->campaign_id);
        $stat = $response->stat;
        return view('portal.sms_schedule.campaign_stat',compact('stat','title','is_active'));
    }

    public function purchaseHistory(){
        $title = "MyBdApps | Push SMS Purchase History";
        $user_id = session()->get('user_id');
        $is_active = "sms_purchase_history";
        // $lists = UserSMS::where('user_id',$user_id)->where('is_active',1)->paginate(20);
        $lists = UserSMS::where('user_id',$user_id)
                        ->where(function ($query) {
                        $query->where('is_active', 1)
                            ->orWhere(function ($query) {
                                    $query->where('payment_status', 'Pending')
                                        ->where('type', 'Bank');
                                });
                        })
                        ->orderBy('created_at', 'desc')
                        ->paginate(20);            
        return view('portal.sms_schedule.purchase-history',compact('title','is_active','lists'));
    }

    public function campaingForUser(){
        session()->forget('dateRangeStat');
        session()->forget('message');
        $title = "MyBdApps | Campaing Stat";
        $is_active = "campaing_stat";
        $data = [];
        return view('portal.sms_schedule.campain_stat_user', compact('title','is_active','data'));
    }

    public function campaingForAdmin(){
        session()->forget('clientId');
        session()->forget('dateRangeStat');
        session()->forget('message');
        $title = "MyBdApps | Campaing Stat";
        $is_active = "campaing_stat_admin";
        $users = User::where('status',1)->where('role','user')->get();
        $data = [];
        return view('portal.sms_schedule.campain_stat_admin', compact('title','is_active','users','data'));
    }
    
    public function reject ($id){
      $scheduleData = SMSSchedule::where('id', $id)->first();
      $scheduleData->status = -1; //"-1" means push sms schedule reject 
      //   $scheduleData->sms_amount = 0; 
      $scheduleData->save();
      
      $user_email = User::where('id',$scheduleData->user_id)->first();
      $message = 'Push SMS Schedule rejected successfully!';
      $msgString = 'App-'.$scheduleData->app_name.' App Id-'.$scheduleData->app_id.' USSD Code-'.$scheduleData->ussd_code;
      $log_write = storeActivityLog('SMS','Push SMS Schedule reject',$msgString);
      $body = "Your Push SMS Schedule has been rejected!".' '.$msgString;
      $sendTo = $user_email->email;
      \Mail::to($sendTo)->send(new \App\Mail\ScheduleRejectMail($body));
      return redirect()->back()->with('message',$message);
    }

    public function invoicePdf($id){
      $data = $this->invoiceData($id);
      $pdf = PDF::loadView('portal.sms_schedule.pushsmsinvoice', compact('data'));
      return $pdf->download('PushSMS'.$id.'-invoice.pdf');
      return [];
    }

    public static function invoiceData($id){
      $content = UserSMS::select('users.username as uname','users.email as email', 'users.mobile_no as mobile','user_s_m_s.id as invoice','user_s_m_s.amount as credit','user_s_m_s.valid_till as validTill','user_s_m_s.created_at as created','user_s_m_s.vat as vat','user_s_m_s.gateway_charge as charge','user_s_m_s.type as type','user_s_m_s.is_active as pay_status','s_m_s.*')
                          ->join('users', 'users.id', '=', 'user_s_m_s.user_id') 
                          ->join('s_m_s', 's_m_s.id', '=', 'user_s_m_s.sms_id') 
                          ->where('user_s_m_s.id',$id)
                          ->first();
      return $content;                    
    }

    public function storeSlip(Request $request){
        $this->validate($request,[
            'sms_id'=>'required',
            'slip'=>'required|image|mimes:jpeg,png,jpg,gif,svg|max:2000',
        ]);

        $slip = $request->file('slip');            
        $slip_img = rand() . $slip->getClientOriginalName(); 
        $slip->move(public_path('assets/payslip_pushsms'), $slip_img);

        $packDetails = SMS::where('id', $request->input('sms_id'))->where('status', 1)->first();
        $user_id = session()->get('user_id');
        $userPackData = new UserSMS();
        $userPackData->user_id = $user_id;
        $userPackData->sms_id = $request->input('sms_id');
        $userPackData->amount = $packDetails->amount;
        $userPackData->base_price = $packDetails->price;
        $userPackData->vat = env('APP_PSMS_VAT'); // percentage
        $userPackData->gateway_charge = env('APP_PSMS_GATEWAY'); // percentage
        $userPackData->channel = 'push';
        $userPackData->is_active = 0;
        $userPackData->payment_status = 'Pending';
        $userPackData->type = 'Bank';
        $userPackData->slip_file = $slip_img;
        $userPackData->valid_till = date('Y-m-d H:i:s', strtotime(now() . ' +' . $packDetails->validity . ' day'));
        $success = $userPackData->save();

        if($success) {                
            $message = 'pay slip uploded! Please, wait a while till approved.';
            return redirect()->back()->with('message',$message);
        }
        else
        {
            $message = 'Something is wrong, try again!';
            return redirect()->back()->with('message',$message);
        }
    }

    public function bankPayment(){
        $title = "MyBdApps | Push SMS Bank Payment";
        $user_id = session()->get('user_id');
        $is_active = "sms_bank_payment";
        $lists = UserSMS::where('payment_status','Pending')->where('type','Bank')->paginate(20);                   
        return view('portal.sms.psmsbankpayment',compact('title','is_active','lists'));
    }

    public function bankPaymentApprove($id){
      try {
            $obd_pack = UserSMS::findOrFail($id);
            $obd_pack->is_active = 1;
            $obd_pack->payment_status = 'Completed';
            $obd_pack->save();
            $message = 'Push SMS Payment, approved!';
            return redirect()->back()->with('message',$message);
        }catch(Exception $e){
            $message = 'Something is wrong, try again!';
            return redirect()->back()->with('message',$message);
        }
    }
    
}
