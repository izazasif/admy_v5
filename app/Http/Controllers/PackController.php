<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pack;
use App\Models\UserPack;
use App\Models\Schedule;
use PDF;

class PackController extends Controller
{
    public function purchase(){
        $title = "MyBdApps | Pack Purchase";
        $is_active = "purchase_pack";
        $packs = Pack::where('status', 1)->get();
        return view('portal.pack.purchase', compact('title', 'is_active', 'packs'));
    }

    public function checkout($id){
      $title = "MyBdApps | Pack Checkout";
      $is_active = "purchase_pack";
      $packDetails = Pack::where('id', $id)->where('status', 1)->first();

      // \Config::get('bkash.apiUrl');
      $request_token=$this->bkash_Get_Token();
      $id_token=$request_token['id_token'];
      $refresh_token=$request_token['refresh_token'];
      $expires_in=$request_token['expires_in'];
      $token_type=$request_token['token_type'];

      session()->forget('id_token');
      session()->put('id_token', $id_token);
      // dd($request_token);
      $total_amount = $packDetails->price + ($packDetails->price * ((env('APP_OBD_VAT')+env('APP_OBD_GATEWAY')) / 100));
      return view('portal.pack.checkout', compact('title', 'is_active', 'packDetails', 'id_token', 'refresh_token', 'expires_in', 'token_type','total_amount'));
    }

    function bkash_Get_Token(){

      $post_token=array(
        'app_key'=>\Config::get('bkash.app_key'),
        'app_secret'=>\Config::get('bkash.app_secret')
      );

      $url=curl_init(\Config::get('bkash.tokenURL'));
      $proxy = \Config::get('bkash.proxy');
      $posttoken=json_encode($post_token);
      $header=array(
        'Content-Type:application/json',
        'password:'.\Config::get('bkash.password'),
            'username:'.\Config::get('bkash.username')
        );

      curl_setopt($url,CURLOPT_HTTPHEADER, $header);
      curl_setopt($url,CURLOPT_CUSTOMREQUEST, "POST");
      curl_setopt($url,CURLOPT_RETURNTRANSFER, true);
      curl_setopt($url,CURLOPT_POSTFIELDS, $posttoken);
      curl_setopt($url,CURLOPT_FOLLOWLOCATION, 1);
      curl_setopt($url,CURLOPT_TIMEOUT,30);
      //curl_setopt($url, CURLOPT_PROXY, $proxy);
      $resultdata=curl_exec($url);
      curl_close($url);
      return json_decode($resultdata, true);
    }

    public function purchaseSelect($id){
      $user_id = session()->get('user_id');
      $packDetails = Pack::where('id', $id)->first();

      $userPackData = new UserPack;
      $userPackData->user_id = $user_id;
      $userPackData->pack_id = $id;
      $userPackData->amount = $packDetails->amount;
      $userPackData->valid_till = date('Y-m-d H:i:s', strtotime(now() . ' +'.$packDetails->validity.' day'));
      $userPackData->save();

      // $user_credit = UserPack::where('user_id', $user_id)->where('valid_till', '>=', date('Y-m-d H:i:s'))->where('status', 1)->sum('amount');
      // $user_debit = Schedule::where('user_id', $user_id)->sum('obd_amount');
      // session()->put('user_credit', $user_credit-$user_debit);
      $userOBDBalance = getUserOBDBalance($user_id);
      session()->put('user_credit', $userOBDBalance);

      $message = 'Pack purchased successfully!';

      return redirect()->back()->with('message',$message);
    }

    public function history(Request $request){
      $title = "MyBdApps | Pack History";
      $is_active = "purchase_history";
      $packs = Pack::where('status', 1)->get();

      // $user_id = session()->get('user_id');
      // $user_packs = UserPack::where('user_id', $user_id)->orderBy('created_at', 'DESC')->paginate(10);
      $this->manageSession($request);
      $user_packs = $this->getContentQueryBuilder();
      $user_packs = $user_packs->paginate(50);

      return view('portal.pack.history', compact('title', 'is_active', 'packs', 'user_packs'));
    }

    public function reset() {
      session()->forget('shpdaterange');
      session()->forget('shpack');

      return redirect()->route('pack.history');
    }

    private function manageSession(Request $request){

      $shpdaterange = '';
      if( $request->has('shpdaterange') ) {
        $shpdaterange = $request->shpdaterange;
      } elseif( session()->has('shpdaterange') ) {
        $shpdaterange = session()->get('shpdaterange');
      }
      session()->put('shpdaterange', $shpdaterange);

      $shpack = '';
      if( $request->has('shpack') ) {
        $shpack = $request->shpack;
      } elseif( session()->has('shpack') ) {
        $shpack = session()->get('shpack');
      }
      session()->put('shpack', $shpack);

      return;
    }

    private function getContentQueryBuilder(){
      $shpdaterange = session()->get('shpdaterange');
      $shpack = session()->get('shpack');

      $user_id = session()->get('user_id');
      $contents = UserPack::where('user_id',$user_id)
                        ->where(function ($query) {
                        $query->where('status', 1)
                            ->orWhere(function ($query) {
                                    $query->where('status', 0)
                                        ->where('type', 'Bank');
                                });
                        })
                        ->orderBy('created_at', 'desc');
                         
      // $contents = UserPack::where('user_id', $user_id)->orderBy('created_at','desc');
      if( $shpdaterange ) {
          $shpdaterange = (explode(" - ", $shpdaterange));
          $shfromdate = $shpdaterange[0];
          $shtodate = $shpdaterange[1];

          $contents = $contents->where('created_at', '>=', date('Y-m-d', strtotime($shfromdate)));
          $contents = $contents->where('created_at', '<=', date('Y-m-d', strtotime($shtodate . ' +1 day')));
      }
      if( $shpack ) {
        $contents = $contents->where('pack_id', $shpack);
      }
      return $contents;
    }

    public function faq(){
      $title = "MyBdApps | FAQ";
      $is_active = "faq";

      return view('portal.faq', compact('title', 'is_active'));
    }

    public function index(){
      $title = "MyBdApps | OBD Pack List";
      $is_active = "pack_list";

      $packs = Pack::paginate(50);

      return view('portal.pack.list', compact('title', 'is_active', 'packs'));
    }

    public function create(){
      $title = "MyBdApps | Create OBD Pack";
      $is_active = "pack_create";

      return view('portal.pack.create', compact('title', 'is_active'));
    }

    public function store(Request $request){
      $rules = [
          'name' => 'required',
          'unit_price' => 'required',
          'price' => 'required',
          'amount' => 'required',
          'validity' => 'required',
          'status' => 'required',
      ];

      $messages = [
          'name.required' => 'Name field is required!',
          'unit_price.required' => 'Unit Price field is required!',
          'price.required' => 'Total Price field is required!',
          'amount.required' => 'Amount field is required!',
          'validity.required' => 'Validity field is required!',
          'status.required' => 'Status field is required!',
      ];

      $this->validate($request, $rules, $messages);

      $packData = new Pack;
      $packData->name = $request->name;
      $packData->unit_price = $request->unit_price;
      $packData->price = $request->price;
      $packData->amount = $request->amount;
      $packData->validity = $request->validity;
      $packData->status = $request->status;
      $packData->save();

      $message = 'OBD Pack Created Successfully!';
      $log_write = storeActivityLog('OBD','OBD Pack Create',json_encode($request->all()));
      return redirect()->route('pack.list')->with('message',$message);
    }

    public function edit($id){
      $title = "MyBdApps | Edit OBD Pack";
      $is_active = "pack_edit";

      $packDetail = Pack::where('id', $id)->first();

      return view('portal.pack.edit', compact('title', 'is_active', 'packDetail'));
    }

    public function update(Request $request){
      $rules = [
          'name' => 'required',
          'unit_price' => 'required',
          'price' => 'required',
          'amount' => 'required',
          'validity' => 'required',
          'status' => 'required',
      ];

      $messages = [
          'name.required' => 'Name field is required!',
          'unit_price.required' => 'Unit Price field is required!',
          'price.required' => 'Total Price field is required!',
          'amount.required' => 'Amount field is required!',
          'validity.required' => 'Validity field is required!',
          'status.required' => 'Status field is required!',
      ];

      $this->validate($request, $rules, $messages);

      $pack_id = $request->pack_id;

      $packData = Pack::where('id', $pack_id)->first();
      $packData->name = $request->name;
      $packData->unit_price = $request->unit_price;
      $packData->price = $request->price;
      $packData->amount = $request->amount;
      $packData->validity = $request->validity;
      $packData->status = $request->status;
      $packData->save();

      $message = 'OBD Pack Updated Successfully!';
      $log_write = storeActivityLog('OBD','OBD Pack Update',json_encode($request->all()));
      return redirect()->route('pack.list')->with('message',$message);
    }

    public function invoicePdf($id){
      $data = $this->invoiceData($id);
      $pdf = PDF::loadView('portal.pack.obdinvoice', compact('data'));
      return $pdf->download('OBD'.$id.'-invoice.pdf');
    }

    public static function invoiceData($id){
      $content = UserPack::select('users.username as uname','users.email as email', 'users.mobile_no as mobile','user_packs.id as invoice','user_packs.amount as credit','user_packs.valid_till as validTill','user_packs.created_at as created','user_packs.vat as vat','user_packs.gateway_charge as charge','user_packs.type as type','user_packs.status as pay_status','packs.*')
                          ->join('users', 'users.id', '=', 'user_packs.user_id') 
                          ->join('packs', 'packs.id', '=', 'user_packs.pack_id') 
                          ->where('user_packs.id',$id)
                          ->first();
      return $content;                    
    }  

    public function storeSlip(Request $request){
        $this->validate($request,[
            'obd_id'=>'required',
            'slip'=>'required|image|mimes:jpeg,png,jpg,gif,svg|max:2000',
        ]);

        $slip = $request->file('slip');            
        $slip_img = rand() . $slip->getClientOriginalName(); 
        $slip->move(public_path('assets/payslip_obd'), $slip_img);

        $packDetails = Pack::where('id', $request->input('obd_id'))->where('status', 1)->first();
        $user_id = session()->get('user_id');
        $userPackData = new UserPack();
        $userPackData->user_id = $user_id;
        $userPackData->pack_id = $request->input('obd_id');
        $userPackData->amount = $packDetails->amount;
        $userPackData->base_price = $packDetails->price;
        $userPackData->vat = env('APP_OBD_VAT'); // percentage
        $userPackData->gateway_charge = env('APP_OBD_GATEWAY'); // percentage
        $userPackData->status = 0;
        $userPackData->type = 'Bank';
        $userPackData->slip_file = $slip_img;
        $userPackData->valid_till = date('Y-m-d H:i:s', strtotime(now() . ' +' . $packDetails->validity . ' day'));
        $success = $userPackData->save();

        if($success) {                
            $message = 'pay slip uploded! Please, wait a while till approved.';
            //email to authority
            $data = self::invoiceData($userPackData->id);
            $sub_total = $data->price + ($data->price * (( $data->vat + $data->charge) / 100));
            $pdf = PDF::loadView('portal.sms_schedule.pushsmsinvoice', compact('data'));
            $body = 'Dear Concern, <br/> You have received a payment slip '.$data->amount. ' amount of OBD.<br/> '.'Total price '.$sub_total. ' (Included VAT'. env('APP_PSMS_VAT').'% and Getway Charge '.env('APP_PSMS_GATEWAY'). '%).<br/>Please check and approve accordingly.<br/>Thank you!';
            $authority_email = ['anisur.rahman@miaki.co', 'asad.zaman@miaki.co', 'yusuf.shumon@miaki.co'];
           \Mail::to($authority_email)->send(new \App\Mail\InvoiceMail($body,$pdf->output()));
           
            return redirect()->back()->with('message',$message);
        }
        else
        {
            $message = 'Something is wrong, try again!';
            return redirect()->back()->with('message',$message);
        }
    }

    public function bankPayment(Request $request){
      $title = "MyBdApps | OBD Bank Payment";
      $is_active = "obd_bank_payment";
      $packs = Pack::where('status', 1)->get();
      $lists = UserPack::select('user_packs.*','users.username','users.email')->join('users', 'users.id', '=', 'user_packs.user_id')->where('user_packs.status',0)->where('user_packs.type','Bank')->paginate(20);      
      return view('portal.pack.obdbankpayment', compact('title', 'is_active', 'lists'));
    }

    public function bankPaymentApprove($id){
      try {
            $obd_pack = UserPack::findOrFail($id);
            $obd_pack->status = 1;
            $obd_pack->save();
            $message = 'OBD Payment, approved!';

            $data = self::invoiceData($id);
            $sub_total = $data->price + ($data->price * (( $data->vat + $data->charge) / 100));
            $pdf = PDF::loadView('portal.pack.obdinvoice', compact('data'));
            $body = 'Dear Developer, <br/> you have purchased '.$data->amount. ' amount of OBD.<br/> '.'Total price '.$sub_total. ' (Included VAT '.env('APP_PSMS_VAT').'% and Getway Charge '.env('APP_OBD_GATEWAY').'%).<br/>please, find attached the invoice.';                
            \Mail::to($data->email)->send(new \App\Mail\InvoiceMail($body,$pdf->output()));

            return redirect()->back()->with('message',$message);
        }catch(Exception $e){
            $message = 'Something is wrong, try again!';
            return redirect()->back()->with('message',$message);
        }
    }
    public function bankPaymentReject($id){
      try {
            $obd_pack = UserPack::findOrFail($id);
            $obd_pack->status = -1;
            $obd_pack->save();
            $message = 'OBD Payment, Rejected!';

            // $data = self::invoiceData($id);
            // $sub_total = $data->price + ($data->price * (( $data->vat + $data->charge) / 100));
            // $pdf = PDF::loadView('portal.pack.obdinvoice', compact('data'));
            // $body = 'Dear Developer, <br/> you have purchased '.$data->amount. ' amount of OBD.<br/> '.'Total price '.$sub_total. ' (Included VAT '.env('APP_PSMS_VAT').'% and Getway Charge '.env('APP_OBD_GATEWAY').'%).<br/>please, find attached the invoice.';                
            // \Mail::to($data->email)->send(new \App\Mail\InvoiceMail($body,$pdf->output()));

            return redirect()->back()->with('message',$message);
        }catch(Exception $e){
            $message = 'Something is wrong, try again!';
            return redirect()->back()->with('message',$message);
        }
    }
    

}
