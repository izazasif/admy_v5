<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pack;
use App\Models\UserPack;
use App\Models\Schedule;

class PackController extends Controller
{
    public function purchase(){
        $title = "AdMy | Pack Purchase";
        $is_active = "purchase_pack";
        $packs = Pack::where('status', 1)->get();
        return view('portal.pack.purchase', compact('title', 'is_active', 'packs'));
    }

    public function checkout($id){
      $title = "AdMy | Pack Checkout";
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

      return view('portal.pack.checkout', compact('title', 'is_active', 'packDetails', 'id_token', 'refresh_token', 'expires_in', 'token_type'));
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
      $title = "AdMy | Pack History";
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
      $contents = UserPack::where('user_id', $user_id)->orderBy('created_at','desc');
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
      $title = "AdMy | FAQ";
      $is_active = "faq";

      return view('portal.faq', compact('title', 'is_active'));
    }

    public function index(){
      $title = "AdMy | OBD Pack List";
      $is_active = "pack_list";

      $packs = Pack::paginate(50);

      return view('portal.pack.list', compact('title', 'is_active', 'packs'));
    }

    public function create(){
      $title = "AdMy | Create OBD Pack";
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
      $title = "AdMy | Edit OBD Pack";
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

}
