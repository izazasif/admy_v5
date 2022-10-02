<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Models\UserWebAPI;
use App\Models\WebApi;
use Illuminate\Http\Request;

class WebApiController extends Controller
{
    public function index(){
        $title = "AdMy | Web API List";
        $is_active = "web_api_list";
        $lists = WebApi::paginate(50);
        return view('portal.web-api.list', compact('title', 'is_active', 'lists'));
    }

    public function create(){
        $title = "AdMy | Create Web API";
        $is_active = "web_api_create";
        return view('portal.web-api.create', compact('title', 'is_active'));
    }


    public function store(Request $request){
        $rules = [
            'acquisition' => 'required',
            'price' => 'required|numeric',
            'status' => 'required',
        ];

        $messages = [
            'acquisition.required' => 'Acquisition field is required!',
            'price.required' => 'Pirce field is required!',
            'price.numeric' => 'Price field must numeric!',
            'status.required' => 'Status field is required!',
        ];

        $this->validate($request, $rules, $messages);


        $web = new WebApi();
        $web->acquisition = $request->acquisition;
        $web->price = $request->price;
        $web->status = $request->status;
        $web->save();

        $message = 'Web API created successfully!';
        return redirect()->route('web.api.list')->with('message',$message);
    }

    public function edit($id){
        $title = "AdMy | Edit Web API";
        $is_active = "web_api_edit";
        $web = WebApi::where('id',$id)->first();

        return view('portal.web-api.edit', compact('title', 'is_active', 'web'));
    }

    public function update(Request $request){
        $rules = [
            'acquisition' => 'required',
            'price' => 'required|numeric',
            'status' => 'required',
        ];

        $messages = [
            'acquisition.required' => 'Acquisition field is required!',
            'price.required' => 'Pirce field is required!',
            'price.numeric' => 'Price field must numeric!',
            'status.required' => 'Status field is required!',
        ];

        $this->validate($request, $rules, $messages);

        $id = $request->id;

        $web = WebApi::where('id', $id)->first();
        $web->acquisition = $request->acquisition;
        $web->price = $request->price;
        $web->status = $request->status;
        $web->save();

        $message = 'Web API updated successfully!';
        return redirect()->route('web.api.list')->with('message',$message);
    }

    public function purchase(){
        $title = "AdMy | Web API Purchase";
        $is_active = "purchase_web_api";
        $webs = WebApi::where('status', 1)->where('acquisition','!=',0)->get();
        return view('portal.web-api.purchase', compact('title', 'is_active', 'webs'));
    }

    public function checkout($id){
        $title = "AdMy | Web API Checkout";
        $is_active = "purchase_web_api";
        $packDetails = WebApi::where('id', $id)->where('status', 1)->first();
        if($packDetails) {
            $ac = $packDetails->acquisition;
        }else{
            return redirect()->back();
        }
        $user_id = session()->get('user_id');

        $api = new UserWebAPI();
        $api->user_id = $user_id;
        $api->web_api_id = $packDetails->id;
        $api->acquisition = $ac;
        $api->price  = $packDetails->price;
        $success = $api->save();
        if($success) {

            $bkash = new WebBikashController();
            $token = $bkash->getToken();
            session()->put('bkash_token', $token);
            $user_pack_id = $api->id;
            return view('portal.web-api.checkout', compact('title', 'is_active', 'api', 'user_pack_id'));
        }

    }

    public function checkoutPost(Request $request){
        $rules = [
            'acquisition' => 'required|numeric',
        ];

        $messages = [
            'acquisition.required' => 'Acquisition field is required!',
            'acquisition.numeric' => 'Acquisition field is numeric!',
        ];
        $title = "AdMy | Web API Checkout";
        $is_active = "purchase_web_api";
        $packDetails = WebApi::where('acquisition',0)->where('status', 1)->first();
        if($packDetails) {
            $ac = $request->acquisition;
            $price = $ac * $packDetails->price;
            $user_id = session()->get('user_id');
            $api = new UserWebAPI();
            $api->user_id = $user_id;
            $api->web_api_id = $packDetails->id;
            $api->acquisition = $ac;
            $api->price  = $price;
            $success = $api->save();
            if($success) {

                $bkash = new WebBikashController();
                $token = $bkash->getToken();
                session()->put('bkash_token', $token);
                $user_pack_id = $api->id;
                return view('portal.web-api.checkout', compact('title', 'is_active', 'api', 'user_pack_id'));
            }

        }else{
            return redirect()->back();
        }
    }

    public function purchaseHistory(){
        $title = "AdMy | Web API purchase history";
        $is_active = "web_api_purchase_history";
        $user_id = session()->get('user_id');
        $lists = UserWebAPI::where('user_id',$user_id)->paginate(20);
        return view('portal.web-api.purchase_history', compact('title', 'is_active', 'lists'));
    }
}
